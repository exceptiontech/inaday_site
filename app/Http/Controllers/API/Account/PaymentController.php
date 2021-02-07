<?php
 
namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
 
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
use App\Transaction;
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
        $this->gateway->setTestMode(env('PAYPAL_TEST_MODE')); 
    }
 
 


    public function payment_success(Request $request)
    {



        function percentPlus($number,$percent) {
            $total = ($number / $percent ) + $number;
            return $total;
        }

        function percentMinus($number,$percent) {
            $total = $number - ($number / $percent ) ;
            return $total;
        }


        // Once the transaction has been approved, we need to complete it.
        if ($request->payment_id && $request->payer_id)
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->payer_id,
                'transactionReference' => $request->payment_id,
            ));

            $response = $transaction->send();
         

            if ($response->isSuccessful())
            {

                if ($request->service_id) {
                    $id = $request->service_id;
                    $type = 'service';
                }elseif ($request->mixture_id) {
                    $id = $request->mixture_id;
                    $type = 'mixture';
                }elseif ($request->offer_id) {
                    $id = $request->offer_id;
                    $type = 'offer';
                }else {
                    $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

                    return \Response::json(['error'=> $arr]);
                }



                if ($type == 'offer') {

                    $offer = Offer::find($id);

                    if (!$offer) {
                        $arr = array("status" => 103, "errorMsg" => 'offer id not exist', "data" => array(),"appearForUser" => true);

                        return \Response::json(['error'=> $arr]);
                    }
             

                    $payment = new Payment;
                    $payment->payment_id = $request->payment_id;
                    $payment->payer_id = $request->payer_id;
                    $payment->payer_email = $request->email;
                    $payment->amount = $request->amount;
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $request->state;
                    $payment->save();

                    if ($payment) {
                        $booking = new Booking;
                        $booking->offer_id = $id;
                        $booking->project_id = $offer->project_id;
                        $booking->user_id = Auth::id();
                        $booking->provider_id = $offer->user->id;
                        $booking->payment_id = $payment->id;
                        $booking->status_id = 2;
                        $booking->save();

                        $offer->is_confirmed = 1;
                        $offer->save();

                        if ($booking) {

                            // for services provider
                            $transaction = new Transaction;
                            //$transaction->mount = percentMinus($offer->price,10);
                            $transaction->mount = $offer->price;
                            $transaction->type = 'plus'; // plus or minus
                            $transaction->title = 'ربح';
                            $transaction->user_id = $offer->user->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 0; // except project complete 
                            $transaction->save();

                            // for entrupeneur 
                            $transaction = new Transaction;
                            //$transaction->mount = percentPlus($offer->price,10);
                            $transaction->mount = $offer->price;
                            $transaction->type = 'sell'; // sell or refund
                            $transaction->title = 'شراء';
                            $transaction->user_id = Auth::user()->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 1;  
                            $transaction->save();
                        }



                        $offer->user->notify(new \App\Notifications\Database\BookingCreated($booking));

                        if ($offer->user->usersettings && $offer->user->usersettings->booking_notifications)
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



                    $data['status'] = true;
                    $data['data']['booking'] = $booking;
                    $data['data']['payment'] = $payment;

                    $arr = array("status" => 200,"data" => $data);
                    return \Response::json(['data'=> $arr]);


                }elseif($type == 'service') {
             
                    $service = Service::find($id);

                    if (!$service) {
                        $arr = array("status" => 103, "errorMsg" => 'service id not exist', "data" => array(),"appearForUser" => true);

                        return \Response::json(['error'=> $arr]);
                    }

                    $payment = new Payment;
                    $payment->payment_id = $request->payment_id;
                    $payment->payer_id = $request->payer_id;
                    $payment->payer_email = $request->email;
                    $payment->amount = $request->amount;
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $request->state;
                    $payment->save();

                    if ($payment) {
                        $booking = new Booking;
                        $booking->service_id = $id;
                        $booking->user_id = Auth::id();
                        $booking->provider_id = $service->user->id;
                        $booking->payment_id = $payment->id;
                        $booking->status_id = 2;
                        $booking->save();


                        if ($booking) {

                            // for services provider
                            $transaction = new Transaction;
                            //$transaction->mount = percentMinus($service->cost,10);
                            $transaction->mount = $service->cost;
                            $transaction->type = 'plus'; // plus or minus
                            $transaction->title = 'ربح';
                            $transaction->user_id = $service->user->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 0; // except project complete 
                            $transaction->save();

                            // for entrupeneur 
                            $transaction = new Transaction;
                            //$transaction->mount = percentPlus($service->cost,10);
                            $transaction->mount = $service->cost;
                            $transaction->type = 'sell'; // sell or refund
                            $transaction->title = 'شراء';
                            $transaction->user_id = Auth::user()->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 1;  
                            $transaction->save();
                        }


                        Auth::user()->notify(new \App\Notifications\Database\BookingCreated($booking));

                        if (Auth::user()->usersettings && Auth::user()->usersettings->booking_notifications)
                        {
                            Auth::user()->notify(new BookingCreated($booking));
                        } 

                        $service->user->notify(new \App\Notifications\Database\BookingCreated($booking));

                        if ($service->user->usersettings && $service->user->usersettings->booking_notifications)
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

                    }

                    $data['status'] = true;
                    $data['data']['booking'] = $booking;
                    $data['data']['payment'] = $payment;

                    $arr = array("status" => 200,"data" => $data);
                    return \Response::json(['data'=> $arr]);

                }elseif($type == 'mixture') {


                    $mixture = Mixture::find($id);


                    if (!$mixture) {
                        $arr = array("status" => 103, "errorMsg" => 'mixture id not exist', "data" => array(),"appearForUser" => true);

                        return \Response::json(['error'=> $arr]);
                    }

                    $payment = new Payment;
                    $payment->payment_id = $request->payment_id;
                    $payment->payer_id = $request->payer_id;
                    $payment->payer_email = $request->email;
                    $payment->amount = $request->amount;
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $request->state;
                    $payment->save();

                    if ($payment) {
                        $booking = new Booking;
                        $booking->mixture_id = $id;
                        $booking->user_id = Auth::user()->id;
                        $booking->provider_id = $mixture->team->user->id;
                        $booking->payment_id = $payment->id;
                        $booking->status_id = 2;
                        $booking->save();


                        if ($booking) {

                            // for services provider
                            $transaction = new Transaction;
                            //$transaction->mount = percentMinus($mixture->cost,10);
                            $transaction->mount = $mixture->cost;
                            $transaction->type = 'plus'; // plus or minus
                            $transaction->title = 'ربح';
                            $transaction->user_id = $mixture->team->user->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 0; // except project complete 
                            $transaction->save();

                            // for entrupeneur 
                            $transaction = new Transaction;
                            //$transaction->mount = percentPlus($mixture->cost,10);
                            $transaction->mount = $mixture->cost;
                            $transaction->type = 'sell'; // sell or refund
                            $transaction->title = 'شراء';
                            $transaction->user_id = Auth::user()->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 1;  
                            $transaction->save();
                        }


                        $mixture->team->user->notify(new \App\Notifications\Database\BookingCreated($booking));

                        if ($mixture->team->user->usersettings && $mixture->team->user->usersettings->booking_notifications)
                        {
                            $mixture->team->user->notify(new BookingCreated($booking));
                        } 


                        Auth::user()->notify(new \App\Notifications\Database\BookingCreated($booking));

                        if (Auth::user()->usersettings && Auth::user()->usersettings->booking_notifications)
                        {
                            Auth::user()->notify(new BookingCreated($booking));
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

                    $data['status'] = true;
                    $data['data']['booking'] = $booking;
                    $data['data']['payment'] = $payment;

                    $arr = array("status" => 200,"data" => $data);
                    return \Response::json(['data'=> $arr]);


                } else {
                    return $response->getMessage();
                }

            } else {
                $arr = array("status" => 102, "errorMsg" => 'Transaction not completed', "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }
        }else {
            $arr = array("status" => 101, "errorMsg" => 'missing keys', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }
    }
 
    public function payment_error()
    {
        return 'User is canceled the payment.';
    }
 
}