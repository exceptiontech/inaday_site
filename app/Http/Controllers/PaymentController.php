<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\PaytabsInvoice;
use Basel\Paytabs\Paytabs;


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
 
 
    public function charge(Request $request,$title,$model_id,$offer_id)
    {
        
        if (Auth::user()->isServicesProvider()) {
            return view('front.errors.denied');
        }
        
        function percentPlus($number,$percent) {
            $total = (($percent / 100) * $number) + $number  ;
            return $total;
        }

        function percentMinus($number,$percent) {
            $total = $number - (($percent / 100) * $number) ;
            return $total;
        }

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
                    $total = percentPlus($request->input('amount') , 7);
                    //$total = $request->input('amount');
                    $mount = round($total/3.75,2);
                }else  {
                    return 'something is wrong';
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
            
            if ($model_id != $service->id) {
                return 'access denied';
            }

            if($service)
            {

                Session::put('type','service');
                Session::put('id',$service->id);

                if ($request->input('amount') == $service->cost) {
                    $total = percentPlus($request->input('amount') , 7);
                    //$total = $request->input('amount');
                    $mount = round($total/3.75,2);
                }else  {
                    return 'something is wrong';
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
            
            if ($model_id != $mixture->id) {
                return 'access denied';
            }

            if($mixture)
            {

                Session::put('type','mixture');
                Session::put('id',$mixture->id);

                if ($request->input('amount') == $mixture->cost) {
                    $total = percentPlus($request->input('amount') , 7);
                    //$total = $request->input('amount');
                    $mount = round($total/3.75,2);
                }else  {
                    return 'something is wrong';
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



        function percentPlus($number,$percent) {
            $total = (($percent / 100) * $number) + $number  ;
            return $total;
        }

        function percentMinus($number,$percent) {
            $total = $number - (($percent / 100) * $number) ;
            return $total;
        }



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
                                $transaction->mount = percentMinus($offer->price,7);
                                // $transaction->mount = $offer->price;
                                $transaction->type = 'plus'; // plus or minus
                                $transaction->title = 'ربح';
                                $transaction->user_id = $offer->user->id;
                                $transaction->booking_id = $booking->id;
                                $transaction->is_confirmed = 0; // except project complete 
                                $transaction->save();

                                // for entrupeneur 
                                $transaction = new Transaction;
                                $transaction->mount = percentPlus($offer->price,7);
                                // $transaction->mount = $offer->price;
                                $transaction->type = 'sell'; // sell or refund
                                $transaction->title = 'شراء';
                                $transaction->user_id = Auth::user()->id;
                                $transaction->booking_id = $booking->id;
                                $transaction->is_confirmed = 1;  
                                $transaction->save();
                            }


                            // Auth::user()->notify(new \App\Notifications\Database\BookingCreated($booking));

                            // if (Auth::user()->usersettings && Auth::user()->usersettings->booking_notifications)
                            // {
                            //     Auth::user()->notify(new BookingCreated($booking));
                            // } 



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
                            $booking->user_id = Auth::id();
                            $booking->provider_id = $service->user->id;
                            $booking->payment_id = $payment->id;
                            $booking->status_id = 2;
                            $booking->save();


                            if ($booking) {

                                // for services provider
                                $transaction = new Transaction;
                                $transaction->mount = percentMinus($service->cost,7);
                                // $transaction->mount = $service->cost;
                                $transaction->type = 'plus'; // plus or minus
                                $transaction->title = 'ربح';
                                $transaction->user_id = $service->user->id;
                                $transaction->booking_id = $booking->id;
                                $transaction->is_confirmed = 0; // except project complete 
                                $transaction->save();

                                // for entrupeneur 
                                $transaction = new Transaction;
                                $transaction->mount = percentPlus($service->cost,7);
                                // $transaction->mount = $service->cost;
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

                        return redirect('bookings/'.$booking->id);
                    }
             

                }elseif($type == 'mixture') {

                    // The customer has successfully paid.
                    $arr_body = $response->getData();
             
                    // Insert transaction data into the database
                    $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->first();

                    $mixture = Mixture::findorfail($id);

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
                        $booking->provider_id = $mixture->team->user->id;
                        $booking->payment_id = $payment->id;
                        $booking->status_id = 2;
                        $booking->save();


                        if ($booking) {

                            // for services provider
                            $transaction = new Transaction;
                            $transaction->mount = percentMinus($mixture->cost,7);
                            // $transaction->mount = $mixture->cost;
                            $transaction->type = 'plus'; // plus or minus
                            $transaction->title = 'ربح';
                            $transaction->user_id = $mixture->team->user->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 0; // except project complete 
                            $transaction->save();

                            // for entrupeneur 
                            $transaction = new Transaction;
                            $transaction->mount = percentPlus($mixture->cost,7);
                            // $transaction->mount = $mixture->cost;
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


    public function Paytabs(Request $request,$title,$model_id,$offer_id)
    {

        if (Auth::user()->isServicesProvider()) {
            return view('front.errors.denied');
        }
        
        function percentPlus($number,$percent) {
            $total = (($percent / 100) * $number) + $number  ;
            return $total;
        }

        function percentMinus($number,$percent) {
            $total = $number - (($percent / 100) * $number) ;
            return $total;
        }

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
                    $total = percentPlus($request->input('amount') , 7);
                    //$total = $request->input('amount');
                    $mount = round($total/3.75,2);
                }else  {
                    return 'something is wrong';
                }

                $result = Paytabs::getInstance()->create_pay_page(array(

                    //Customer's Personal Information
                    'cc_first_name' => Auth::user()->first_name,          
                    'cc_last_name' => Auth::user()->last_name,
                    'cc_phone_number' => Auth::user()->mobile,
                    'phone_number' => Auth::user()->mobile,
                    'email' => Auth::user()->email,

                    'billing_address' => Auth::user()->userdetail->first()->country->title['en'] ?? 'Saudi Arabia' ,
                    'city' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'state' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'postal_code' => "11461",
                    'country' => "SA",

                    'address_shipping' => Auth::user()->first_name." ".Auth::user()->last_name,
                    'city_shipping' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'state_shipping' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'postal_code_shipping' => "11461",
                    'country_shipping' => "SA",

                    //Product Information
                    "products_per_title" => "#id: " .$offer->id ." - ".$offer->offer ."#project id: " .$project->id ." - ".$project->title,   
                    'quantity' => "1",
                    'unit_price' => $mount,
                    "other_charges" => "00.00",
                    'amount' => $mount,                                 
                    'discount' => "00.00",
                    'title' => Auth::user()->first_name." ".Auth::user()->last_name, 
                    "reference_no" => $offer->id,      
                ));


                if ($result->response_code == 4012) {
                    return redirect($result->payment_url);
                }
                if ($result->response_code == 4094) {
                    return $result->details;
                }

                return $result->result;

            }

        }elseif (str_contains($url, 'services')) {

            $service = Service::where('title', 'like', '%' . $title . '%')->where('id',$model_id)->first();
            
            if ($model_id != $service->id) {
                return 'access denied';
            }

            if($service)
            {

                Session::put('type','service');
                Session::put('id',$service->id);

                if ($request->input('amount') == $service->cost) {
                    $total = percentPlus($request->input('amount') , 7);
                    //$total = $request->input('amount');
                    $mount = round($total/3.75,2);

                    //return $total . '-'. $mount;
                }else  {
                    return 'something is wrong';
                }

                $result = Paytabs::getInstance()->create_pay_page(array(

                    //Customer's Personal Information
                    'cc_first_name' => Auth::user()->first_name,          
                    'cc_last_name' => Auth::user()->last_name,
                    'cc_phone_number' => Auth::user()->mobile,
                    'phone_number' => Auth::user()->mobile,
                    'email' => Auth::user()->email,

                    'billing_address' => Auth::user()->userdetail->first()->country->title['en'] ?? 'Saudi Arabia' ,
                    'city' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'state' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'postal_code' => "11461",
                    'country' => "SA",

                    'address_shipping' => Auth::user()->first_name." ".Auth::user()->last_name,
                    'city_shipping' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'state_shipping' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'postal_code_shipping' => "11461",
                    'country_shipping' => "SA",

                    //Product Information
                    "products_per_title" => "#id: " .$service->id ." - ".$service->title,   
                    'quantity' => "1",
                    'unit_price' => $mount,
                    "other_charges" => "00.00",
                    'amount' => $mount,                                 
                    'discount' => "00.00",
                    'title' => Auth::user()->first_name." ".Auth::user()->last_name, 
                    "reference_no" => $service->id,      
                ));


                if ($result->response_code == 4012) {
                    return redirect($result->payment_url);
                }
                if ($result->response_code == 4094) {
                    return $result->details;
                }

                return $result->result;

            }


        }elseif (str_contains($url, 'mixtures')) {

            $mixture = Mixture::where('title', 'like', '%' . $title . '%')->where('id',$model_id)->first();
            
            if ($model_id != $mixture->id) {
                return 'access denied';
            }


            if($mixture)
            {

                Session::put('type','mixture');
                Session::put('id',$mixture->id);

                if ($request->input('amount') == $mixture->cost) {
                    $total = percentPlus($request->input('amount') , 7);
                    //$total = $request->input('amount');
                    $mount = round($total/3.75,2);
                }else  {
                    return 'something is wrong';
                }

                $result = Paytabs::getInstance()->create_pay_page(array(

                    //Customer's Personal Information
                    'cc_first_name' => Auth::user()->first_name,          
                    'cc_last_name' => Auth::user()->last_name,
                    'cc_phone_number' => Auth::user()->mobile,
                    'phone_number' => Auth::user()->mobile,
                    'email' => Auth::user()->email,

                    'billing_address' => Auth::user()->userdetail->first()->country->title['en'] ?? 'Saudi Arabia' ,
                    'city' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'state' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'postal_code' => "11461",
                    'country' => "SA",

                    'address_shipping' => Auth::user()->first_name." ".Auth::user()->last_name,
                    'city_shipping' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'state_shipping' => Auth::user()->userdetail->first()->city->title['en'] ?? 'Riyadh',
                    'postal_code_shipping' => "11461",
                    'country_shipping' => "SA",

                    //Product Information
                    "products_per_title" => "#id: " .$mixture->id ." - ".$mixture->title,   
                    'quantity' => "1",
                    'unit_price' => $mount,
                    "other_charges" => "00.00",
                    'amount' => $mount,                                 
                    'discount' => "00.00",
                    'title' => Auth::user()->first_name." ".Auth::user()->last_name, 
                    "reference_no" => $mixture->id,      
                ));

                if ($result->response_code == 4012) {
                    return redirect($result->payment_url);
                }
                if ($result->response_code == 4094) {
                    return $result->details;
                }

                return $result->result;


            }            
        }


    }

    public function PaytabsResponse(Request $request)
    {

        return $request;


        function percentPlus($number,$percent) {
            $total = (($percent / 100) * $number) + $number  ;
            return $total;
        }

        function percentMinus($number,$percent) {
            $total = $number - (($percent / 100) * $number) ;
            return $total;
        }

        $result = Paytabs::getInstance()->verify_payment($request->payment_reference);

        if ($result->response_code == 100) {

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
                            $transaction->mount = percentMinus($offer->price,7);
                            // $transaction->mount = $offer->price;
                            $transaction->type = 'plus'; // plus or minus
                            $transaction->title = 'ربح';
                            $transaction->user_id = $offer->user->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 0; // except project complete 
                            $transaction->save();

                            // for entrupeneur 
                            $transaction = new Transaction;
                            $transaction->mount = percentPlus($offer->price,7);
                            // $transaction->mount = $offer->price;
                            $transaction->type = 'sell'; // sell or refund
                            $transaction->title = 'شراء';
                            $transaction->user_id = Auth::user()->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 1;  
                            $transaction->save();
                        }


                        // Auth::user()->notify(new \App\Notifications\Database\BookingCreated($booking));

                        // if (Auth::user()->usersettings && Auth::user()->usersettings->booking_notifications)
                        // {
                        //     Auth::user()->notify(new BookingCreated($booking));
                        // } 



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
                        $booking->user_id = Auth::id();
                        $booking->provider_id = $service->user->id;
                        $booking->payment_id = $payment->id;
                        $booking->status_id = 2;
                        $booking->save();


                        if ($booking) {

                            // for services provider
                            $transaction = new Transaction;
                            $transaction->mount = percentMinus($service->cost,7);
                            // $transaction->mount = $service->cost;
                            $transaction->type = 'plus'; // plus or minus
                            $transaction->title = 'ربح';
                            $transaction->user_id = $service->user->id;
                            $transaction->booking_id = $booking->id;
                            $transaction->is_confirmed = 0; // except project complete 
                            $transaction->save();

                            // for entrupeneur 
                            $transaction = new Transaction;
                            $transaction->mount = percentPlus($service->cost,7);
                            // $transaction->mount = $service->cost;
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

                    return redirect('bookings/'.$booking->id);
                }
         

            }elseif($type == 'mixture') {

                // The customer has successfully paid.
                $arr_body = $response->getData();
         
                // Insert transaction data into the database
                $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->first();

                $mixture = Mixture::findorfail($id);

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
                    $booking->provider_id = $mixture->team->user->id;
                    $booking->payment_id = $payment->id;
                    $booking->status_id = 2;
                    $booking->save();


                    if ($booking) {

                        // for services provider
                        $transaction = new Transaction;
                        $transaction->mount = percentMinus($mixture->cost,7);
                        // $transaction->mount = $mixture->cost;
                        $transaction->type = 'plus'; // plus or minus
                        $transaction->title = 'ربح';
                        $transaction->user_id = $mixture->team->user->id;
                        $transaction->booking_id = $booking->id;
                        $transaction->is_confirmed = 0; // except project complete 
                        $transaction->save();

                        // for entrupeneur 
                        $transaction = new Transaction;
                        $transaction->mount = percentPlus($mixture->cost,7);
                        // $transaction->mount = $mixture->cost;
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

                    return redirect('bookings/'.$booking->id);
                }
     
            } else {
                return $response->getMessage();
            }



            $this->createInvoice((array)$result);
        }
        return $result->result;
    }

    public function createInvoice($request)
    {
        $request['order_id'] = $request["reference_no"];
        PaytabsInvoice::create($request);
    }

 
}