<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Validator;
use Session;
use Redirect;
use Input;
use Carbon\Carbon;
use DB;
use Auth;
use Config;
use App;
use Mail;

use Omnipay\Omnipay;
use App\Payment;
use App\Service;
use App\Log;
use App\Booking;
use App\Project;
use App\Offer;
use App\Mixture;
use URL;


use App\Notifications\BookingCreated;

 
class PaymentController extends Controller
{
 
    public $gateway;
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(env('PAYPAL_TEST_MODE')); //set it to 'false' when go live
    }
 
    public function index()
    {
        return view('payment');
    }
 
    public function charge(Request $request,$title,$model_id,$offer_id)
    {

        $url = URL::previous();

        if (str_contains($url, 'projects')) {

            $project = Project::where('title', 'like', '%' . $title . '%')->where('id',$model_id)->first();

            $offer = Offer::findorfail($offer_id);


            if (!$project || $project->id != $offer->project_id) {
                return 'access denied';
            }

            if($project || $offer)
            {

                Session::put('type','offer');
                Session::put('id',$offer->id);

                if ($request->input('amount') == $offer->price) {
                    $mount = round($request->input('amount')/3.75,2);
                }

                try {
                    $response = $this->gateway->purchase(array(
                        'amount' => $mount,
                        'currency' => 'USD',
                        'returnUrl' => url('paymentsuccess'),
                        'cancelUrl' => url('paymenterror'),
                    ))->send();
              
                    if ($response->isRedirect()) {
                        $response->redirect(); // this will automatically forward the customer
                    } else {
                        // not successful
                        return $response->getMessage();
                    }
                } catch(Exception $e) {
                    return $e->getMessage();
                }
            }

        }elseif (str_contains($url, 'services')) {

            $service = Service::where('title', 'like', '%' . $title . '%')->where('id',$model_id)->first();;
            
            if ($id != $service->id) {
                return 'access denied';
            }

            if($service)
            {

                Session::put('type','service');
                Session::put('id',$service->id);

                if ($request->input('amount') == $service->cost) {
                    $mount = round($request->input('amount')/3.75,2);
                }

                try {
                    $response = $this->gateway->purchase(array(
                        'amount' => $mount,
                        'currency' => 'USD',
                        'returnUrl' => url('paymentsuccess'),
                        'cancelUrl' => url('paymenterror'),
                    ))->send();
              
                    if ($response->isRedirect()) {
                        $response->redirect(); // this will automatically forward the customer
                    } else {
                        // not successful
                        return $response->getMessage();
                    }
                } catch(Exception $e) {
                    return $e->getMessage();
                }
            }            
        }elseif (str_contains($url, 'mixtures')) {

            $mixture = Mixture::where('title', 'like', '%' . $title . '%')->where('id',$model_id)->first();;
            
            if ($id != $mixture->id) {
                return 'access denied';
            }

            if($mixture)
            {

                Session::put('type','mixture');
                Session::put('id',$mixture->id);

                if ($request->input('amount') == $mixture->cost) {
                    $mount = round($request->input('amount')/3.75,2);
                }

                try {
                    $response = $this->gateway->purchase(array(
                        'amount' => $mount,
                        'currency' => 'USD',
                        'returnUrl' => url('paymentsuccess'),
                        'cancelUrl' => url('paymenterror'),
                    ))->send();
              
                    if ($response->isRedirect()) {
                        $response->redirect(); // this will automatically forward the customer
                    } else {
                        // not successful
                        return $response->getMessage();
                    }
                } catch(Exception $e) {
                    return $e->getMessage();
                }
            }            
        }


    }

    public function payment_success(Request $request)
    {

        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));

            $response = $transaction->send();
         

            if ($response->isSuccessful())
            {


                $id = Session::get('id');
                $type = Session::get('type');

                Session::forget('id');        
                Session::forget('type');        


                if ($type == 'offer') {


                    $offer = Offer::findorfail($id);


                    // The customer has successfully paid.
                    $arr_body = $response->getData();
             
                    // Insert transaction data into the database
                    $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->latest();
             

                        $payment = new Payment;
                        $payment->payment_id = $arr_body['id'];
                        $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                        $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                        $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                        $payment->currency = env('PAYPAL_CURRENCY');
                        $payment->payment_status = $arr_body['state'];
                        $payment->save();

                        if ($payment) {
                            $booking = new Booking;
                            $booking->offer_id = $id;
                            $booking->project_id = $offer->project_id;
                            $booking->user_id = $offer->user_id;
                            $booking->payment_id = $payment->id;
                            $booking->save();


                            if (Auth::user()->usersettings && Auth::user()->usersettings->booking_notifications)
                            {
                                $offer->user->notify(new BookingCreated($booking));
                            } 


                            if ($payment && $booking) {
                                $log           = new Log;
                                $log->user_id  = Auth::user()->id;
                                $log->action   = 'paypal payment '.$payment->id.' for ' . $booking->id;
                                $log->model    = 'booking';
                                $log->url      = $request->server()['REQUEST_URI'];
                                $log->ip       = $request->server()['REMOTE_ADDR'];
                                $log->save();
                            }
                        }

                        return redirect('bookings/'.$booking->id);
             


                }elseif($type == 'service') {
                    // The customer has successfully paid.
                    $arr_body = $response->getData();
             
                    // Insert transaction data into the database
                    $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->first();
             
                    $service = Service::findorfail($id);

                        $payment = new Payment;
                        $payment->payment_id = $arr_body['id'];
                        $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                        $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                        $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                        $payment->currency = env('PAYPAL_CURRENCY');
                        $payment->payment_status = $arr_body['state'];
                        $payment->save();

                        if ($payment) {
                            $booking = new Booking;
                            $booking->service_id = $id;
                            $booking->user_id = $service->user_id;
                            $booking->payment_id = $payment->id;
                            $booking->save();



                            if (Auth::user()->usersettings && Auth::user()->usersettings->booking_notifications)
                            {
                                $service->user->notify(new BookingCreated($booking));
                            } 


                            if ($payment && $booking) {
                                $log           = new Log;
                                $log->user_id  = Auth::user()->id;
                                $log->action   = 'paypal payment '.$payment->id.' for ' . $booking->id;
                                $log->model    = 'booking';
                                $log->url      = $request->server()['REQUEST_URI'];
                                $log->ip       = $request->server()['REMOTE_ADDR'];
                                $log->save();
                            }

                        return redirect('bookings/'.$booking->id);
                    }
             

                }elseif($type == 'mixtures') {

                    // The customer has successfully paid.
                    $arr_body = $response->getData();
             
                    // Insert transaction data into the database
                    $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->first();
             
                    $payment = new Payment;
                    $payment->payment_id = $arr_body['id'];
                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                    $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $arr_body['state'];
                    $payment->save();

                    if ($payment) {
                        $booking = new Booking;
                        $booking->mixture_id = $id;
                        $booking->user_id = Auth::user()->id;
                        $booking->payment_id = $payment->id;
                        $booking->save();

                        $mixture = Mixture::findorfail($id);

                        if (Auth::user()->usersettings && Auth::user()->usersettings->booking_notifications)
                        {
                            $mixture->team->user->notify(new BookingCreated($booking));
                        } 

                        if ($payment && $booking) {
                            $log           = new Log;
                            $log->user_id  = Auth::user()->id;
                            $log->action   = 'paypal payment '.$payment->id.' for ' . $booking->id;
                            $log->model    = 'booking';
                            $log->url      = $request->server()['REQUEST_URI'];
                            $log->ip       = $request->server()['REMOTE_ADDR'];
                            $log->save();
                        }

                        return redirect('bookings/'.$booking->id);
                    }
         
                } else {
                    return $response->getMessage();
                }

            } else {
                return 'Transaction is declined';
            }
        }
    }
 
    public function payment_error()
    {
        return 'User is canceled the payment.';
    }
 
}