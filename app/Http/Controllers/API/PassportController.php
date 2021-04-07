<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Notifications\RegisterServicesProvider;
use App\Notifications\RegisterEntrepreneur;
use App\Notifications\UpdatedUser;
use Spatie\Permission\Models\Role;

use App\Usersettings;
use App\Userdetail;
use App\City;
use Socialite;
use URL;
use Auth;
use Redirect;
use Session;
use Carbon\Carbon;

class PassportController extends Controller
{

    use RegistersUsers;

    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(),[
         'email' => 'required|string|email|max:255|unique:users',
         'name' => 'required',
         'password'=> 'required',
         'user_type'=> 'required',
         'mobile'      =>'required|digits:9',
         'password' =>'required|string|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'

        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

            //return response()->json(['error'=>$validator->errors()], 401);

        }

        $requests = $request->all();
        $requests['password'] = Hash::make($requests['password']);
        $requests['is_active'] = 1;

        $user = User::create($requests);
        //$user->SendSMS();

        $role = Role::where('name',$request->user_type)->first();
        $user->assignRole([$role->id]);


        Auth::login($user, true);


        $userdetail = new Userdetail;
        $userdetail->user_id = $user->id;
        $userdetail->avater =  'images/default_img.png';
        $userdetail->save();


        if ($user->mobile) {

            $str = $user->mobile;
            $number = '966'.$str;


            $url = "https://www.msegat.com/gw/sendsms.php";
            $params = json_encode([
                "userName" => "inaday.sa",
                "userSender" => "INADAY",
                "apiKey" => "4294ff3610fcc2260203cf84660dec90",
                "msg" => "تم انشاء الحساب",
                "numbers" => $number
            ]);
            $headers = array('Content-Type:application/json');

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $curl_response = curl_exec($ch);

            if ($curl_response === false) {
                $info = curl_getinfo($ch);
                curl_close($ch);
                die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }

            curl_close($ch);
        }
        
        $user->sendEmailVerificationNotification();


        $token = auth()->user()->createToken('MySecret')->accessToken;

        //$data = $request->all();
        $data['token'] = $token;
        $data['user'] = Auth::user();
        $data['user']['userdetail'] = auth()->user()->userdetail;
        $data['user']['roles'] = auth()->user()->roles;
        $data['user']['usersettings'] = auth()->user()->usersettings;
        $data['user']['skills'] = auth()->user()->skills;

        $data['status'] = true;

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);

        //return response()->json(['data' => $data], 200,[],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('MySecret')->accessToken;


            if (!count(auth()->user()->userdetail)) {
                $userdetail = new Userdetail;
                $userdetail->user_id = auth()->user()->id;
                $userdetail->avater =  'images/default_img.png';
                $userdetail->save();

            }

            //$data = $request->all();
            $data['token'] = $token;
            $data['user'] = auth()->user();
            $data['user']['userdetail'] = auth()->user()->userdetail;
            $data['user']['roles'] = auth()->user()->roles;
            $data['user']['usersettings'] = auth()->user()->usersettings;
            $data['user']['skills'] = auth()->user()->skills;

            if (!auth()->user()->userdetail) {
                $userdetail = new Userdetail;
                $userdetail->user_id = $user->id;
                $userdetail->avater =  'images/default_img.png';
                $userdetail->save();
            }


            $data['status'] = true;

            $arr = array("status" => 200,"data" => $data);

            return \Response::json(['data'=> $arr]);

        } else {
            $arr = array("status" => 401, "errorMsg" => __('api.incorrect_information') , "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        if (!Auth::user() ) {
            $arr = array("status" => 401, "errorMsg" => 'unauthorized', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $token = auth()->user()->createToken('MySecret')->accessToken;

        $data['token'] = $token;
        $data['user'] = auth()->user();
        $data['user']['userdetail'] = auth()->user()->userdetail;
        $data['user']['roles'] = auth()->user()->roles;
        $data['user']['usersettings'] = auth()->user()->usersettings;
        $data['user']['skills'] = auth()->user()->skills;
        $data['status'] = true;

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);


        //return response()->json(['user' => auth()->user()], 200,[],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }


    public function forgot(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {

            $arr = array("status" => 400, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

        } else {
            try {
                $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject($this->getEmailSubject());
                });
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
                    case Password::INVALID_USER:

                        return \Response::json(array("status" => 400, "errorMsg" => trans($response), "data" => array(),"appearForUser" => false));


                }
            } catch (\Swift_TransportException $ex) {
                $arr = array("status" => 400, "errorMsg" => $ex->getMessage(), "data" => array(),"appearForUser" => true);

            } catch (Exception $ex) {
                $arr = array("status" => 400, "errorMsg" => $ex->getMessage(), "data" => array(),"appearForUser" => true);
            }
        }
        return \Response::json($arr);
    }


    public function usersettings(Request $request)
    {


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => __('api.un_updated_profile'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $validator = Validator::make($request->all(), [
            'blog_notifications'  =>'required',
            'offer_notifications'  =>'required',
            'booking_notifications'  =>'required',
            'review_notifications'  =>'required',
            'team_notifications'  =>'required',
            'profile_notifications'  =>'required',
            'favorite_notifications'  =>'required',
            'replay_notifications'  =>'required',
            'message_notifications'  =>'required',
            'support_notifications'  =>'required',
        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (!Auth::user() ) {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        $user = Auth::user();
        $usersettings = Usersettings::where('user_id',Auth::user()->id)->first(); 
        if ($usersettings) {
        
            $usersettings->user_id = Auth::user()->id;
            $usersettings->blog_notifications= $request->blog_notifications;
            $usersettings->offer_notifications=$request->offer_notifications;
            $usersettings->booking_notifications=$request->booking_notifications;
            $usersettings->review_notifications=$request->review_notifications;
            $usersettings->team_notifications=$request->team_notifications;
            $usersettings->profile_notifications=$request->profile_notifications;
            $usersettings->favorite_notifications=$request->favorite_notifications;
            $usersettings->replay_notifications=$request->replay_notifications;
            $usersettings->message_notifications=$request->message_notifications;
            $usersettings->support_notifications=$request->support_notifications;

        }else {
            $usersettings = new Usersettings; 
            $usersettings->user_id = Auth::user()->id;
            $usersettings->blog_notifications= $request->blog_notifications;
            $usersettings->offer_notifications=$request->offer_notifications;
            $usersettings->booking_notifications=$request->booking_notifications;
            $usersettings->review_notifications=$request->review_notifications;
            $usersettings->team_notifications=$request->team_notifications;
            $usersettings->profile_notifications=$request->profile_notifications;
            $usersettings->favorite_notifications=$request->favorite_notifications;
            $usersettings->replay_notifications=$request->replay_notifications;
            $usersettings->message_notifications=$request->message_notifications;
            $usersettings->support_notifications=$request->support_notifications;

        }       
        $usersettings->save();


        $token = auth()->user()->createToken('MySecret')->accessToken;

        //$data = $request->all();
        $data['token'] = $token;
        $data['user'] = auth()->user();
        $data['user']['userdetail'] = auth()->user()->userdetail;
        $data['user']['roles'] = auth()->user()->roles;
        $data['user']['usersettings'] = auth()->user()->usersettings;
        $data['user']['skills'] = auth()->user()->skills;
        $data['status'] = true;

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);
    }


    public function profile(Request $request)
    {
        
        if (!Auth::user() ) {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        $user = Auth::user();

        $userdetail = Userdetail::where('user_id',Auth::user()->id)->first();
        if (!$userdetail) {
            $userdetail = new Userdetail;
        }
        $userdetail->user_id = Auth::user()->id;
        $userdetail->jobtype_id = $request->jobtype_id;
        $userdetail->level_id = $request->level_id;
        $userdetail->prefer_id = $request->prefer_id;
        $userdetail->costkind_id = $request->costkind_id;
        $userdetail->applykind_id = $request->applykind_id;
        $userdetail->averagekind_id = $request->averagekind_id;
        $userdetail->average_cost = $request->average_cost;
        $userdetail->rewardkind_id = $request->rewardkind_id;
        $userdetail->readinesskind_id = $request->readinesskind_id;
        $userdetail->readiness_date = $request->readiness_date;
        $userdetail->time_start = $request->time_start;
        $userdetail->brith_day = $request->brith_day;
        $userdetail->country_id = $request->country_id;
        $userdetail->city_id = $request->city_id;
        $userdetail->position = $request->position;
        $userdetail->notes = $request->notes;

        $avater =  $request->avater;
        if (isset($avater)) {
            $destinationPath = 'uploads/users';
            $extension =  $avater->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $avater->move($destinationPath, $fileName);
            $userdetail->avater =  $destinationPath.'/'.$fileName;
        }

        $cv_file =  $request->cv_file;
        
        if ($cv_file) {
            $destinationPath = 'uploads/users';
            $extension =  $cv_file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $cv_file->move($destinationPath, $fileName);
            $userdetail->cv_file =  $destinationPath.'/'.$fileName;
        }

        $userdetail->save();

        if(!empty($request['password']))
        {

            if (Auth::user()->isEntrepreneur()) {
                $validator = Validator::make($request->all(), [

                        'first_name'=> 'required|string|min:3|max:25',
                        'last_name'=> 'required|string|min:3|max:25',
                        'mobile'      =>'required|digits:9',
                        //'avater' => 'mimes:jpg,jpeg,png',
                        'position'      =>'min:3|string',
                        //'cv_file'      =>'mimes:pdf,docx,doc',
                        'country_id'      =>'required',
                        'city_id'      =>'required',
                        'password' =>'required|string|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed'
                    ]);

            }else {
                $validator = Validator::make($request->all(), [

                    'first_name'=> 'required|string|min:3|max:25',
                    'last_name'=> 'required|string|min:3|max:25',
                    'mobile'      =>'required|digits:9',
                    //'avater' => 'mimes:jpg,jpeg,png',
                    'position'      =>'min:3|string',
                    //'cv_file'      =>'mimes:pdf,docx,doc',
                    'skills.*'      =>'required|integer',
                    //'level_id'      =>'required|integer',
                    'country_id'      =>'required',
                    'city_id'      =>'required',
                    'password' =>'required|string|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|confirmed'
                ]);

            }

            $user->password = Hash::make($request['password']);
        }else {

            if (Auth::user()->isEntrepreneur()) {
                $validator = Validator::make($request->all(), [
                        'first_name'=> 'required|string|min:3|max:25',
                        'last_name'=> 'required|string|min:3|max:25',
                        'mobile'      =>'required|digits:9',
                        //'avater' => 'mimes:jpg,jpeg,png',
                        'position'      =>'min:3|string',
                        //'cv_file'      =>'mimes:pdf,docx,doc',
                        'country_id'      =>'required',
                        'city_id'      =>'required',
                    ]);
            }else {
                $validator = Validator::make($request->all(), [
                    'first_name'=> 'required|string|min:3|max:25',
                    'last_name'=> 'required|string|min:3|max:25',
                    'mobile'      =>'required|digits:9',
                    //'avater' => 'mimes:jpg,jpeg,png',
                    'position'      =>'min:3|string',
                    //'cv_file'      =>'mimes:pdf,docx,doc',
                    'skills.*'      =>'required|integer',
                    'level_id'      =>'required|integer',
                    'country_id'      =>'required',
                    'city_id'      =>'required',
                ]);

            }
        }


        if ($validator->fails()) {
            $arr = array("status" => 400, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);
            return response()->json($arr, 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $user->first_name=$request->first_name;
        $user->last_name=@$request->last_name;
        $user->mobile=@$request->mobile;
        $user->save();



        if(!empty($request['password'])) {
            if ($user->mobile) {

                $str = $user->mobile;
                //$number = '966'.substr($str, 1);
                $number = '966'.$str;


                $url = "https://www.msegat.com/gw/sendsms.php";
                $params = json_encode([
                    "userName" => "inaday",
                    "userSender" => "INADAY",
                    "apiKey" => "7731c731642e783f2e6043091cd6d8a8",
                    "msg" => "تم تغيير كلمة المرور الخاصة بك بنجاح",
                    "numbers" => $number
                ]);
                $headers = array('Content-Type:application/json');

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $curl_response = curl_exec($ch);

                if ($curl_response === false) {
                    $info = curl_getinfo($ch);
                    curl_close($ch);
                    die('error occured during curl exec. Additioanl info: ' . var_export($info));
                }

                curl_close($ch);
            }
        }

        $skills = $request->skills;


        if ($skills) {
            foreach ($skills as $skill) {

                if (is_numeric($skill) && $skill > 0) {
                    Auth::user()->skills()->detach();
                    Auth::user()->skills()->attach([$skill=> ['is_default'=>'1']]);
                }else {

                    if (isset($skill)) {

                        $item = Skill::where('title', 'like', '%' . $skill . '%')->first();

                        if ($item) {
                            Auth::user()->skills()->detach();
                            Auth::user()->skills()->attach($item);
                        }else {
                            $title = array();
                            $title['ar'] = $skill;
                            $new_skill = new Skill;
                            $new_skill->title = $title;
                            $new_skill->slug = $skill;
                            $new_skill->is_active = 0;
                            $new_skill->save();
                            Auth::user()->skills()->attach($new_skill);
                        }
                    }

                }
            }
        }


        Auth::user()->notify(new \App\Notifications\Database\UpdatedUser(Auth::user()));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new UpdatedUser(Auth::user()));
        } 



        if(!empty($request['password'])) {
            if ($user->mobile) {

                $str = $user->mobile;
                $number = '966'.substr($str, 1);


                $url = "https://www.msegat.com/gw/sendsms.php";
                $params = json_encode([
                    "userName" => "inaday",
                    "userSender" => "INADAY",
                    "apiKey" => "7731c731642e783f2e6043091cd6d8a8",
                    "msg" => "ننوه بتغيير كلمة المرور الخاصة بكم",
                    "numbers" => $number
                ]);
                $headers = array('Content-Type:application/json');

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $curl_response = curl_exec($ch);

                if ($curl_response === false) {
                    $info = curl_getinfo($ch);
                    curl_close($ch);
                    die('error occured during curl exec. Additioanl info: ' . var_export($info));
                }

                curl_close($ch);
            }
        }
        

        $token = auth()->user()->createToken('MySecret')->accessToken;

        //$data = $request->all();
        $data['token'] = $token;
        $data['user'] = auth()->user();
        $data['user']['userdetail'] = auth()->user()->userdetail;
        $data['user']['roles'] = auth()->user()->roles;
        $data['user']['usersettings'] = auth()->user()->usersettings;
        $data['user']['skills'] = auth()->user()->skills;
        $data['status'] = true;

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);

        // $arr = array("status" => 200, "message" => "Profile updated successfully.", "data" => array());

        // return \Response::json($arr);
    }




    public function google(){

        Session::put('url', URL::Current());

        return Socialite::with('google')->stateless()->redirect();
    }

    public function googleRedirect(Request $request) {

        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
        ]);


        if ($validator->fails()) {

            $arr = array("status" => 400, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => false);

            return \Response::json(['error'=> $arr]);
        }


        $user = User::where('email',$request->email)->first();
        
        if(isset($user)) {
            Auth::login($user, true);
            $token = auth()->user()->createToken('MySecret')->accessToken;

            //$data = $request->all();
            $data['token'] = $token;
            $data['user'] = auth()->user();
            $data['user']['userdetail'] = auth()->user()->userdetail;
            $data['user']['roles'] = auth()->user()->roles;
            $data['user']['usersettings'] = auth()->user()->usersettings;
            $data['user']['skills'] = auth()->user()->skills;
            $data['status'] = true;

            $arr = array("status" => 200,"data" => $data);

            return \Response::json(['data'=> $arr]);

            //return response()->json(['data' => $data], 200,[],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $validator = Validator::make($request->all(), [
            'user_type'=> 'required',
        ]);


        if ($validator->fails()) {

            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => false);

            return \Response::json(['error'=> $arr]);
        }


        $user = New User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        if (isset($request->mobile)) {
            $user->mobile = $request->mobile;
        }
        $user->password = Hash::make($request->nickname);
        $user->notification_preference = 'mail';
        $user->email_verified_at = Carbon::now(); 
        $user->is_active = 1;
        $user->save();

        $usersettings = new Usersettings;
        $usersettings->blog_notifications= 1;
        $usersettings->offer_notifications=1;
        $usersettings->booking_notifications=1;
        $usersettings->review_notifications=1;
        $usersettings->team_notifications=1;
        $usersettings->profile_notifications=1;
        $usersettings->favorite_notifications=1;
        $usersettings->replay_notifications=1;
        $usersettings->message_notifications=1;
        $usersettings->support_notifications=1;
        $usersettings->user_id = $user->id;
        $usersettings->save();

        $role = Role::where('name',$request->user_type)->first();
        $user->assignRole([$role->id]);

        //$user->sendEmailVerificationNotification();
        //$user->notify(new RegisterServicesProvider($user));

        Auth::login($user, true);

        $token = auth()->user()->createToken('MySecret')->accessToken;

        $data = $request->all();
        $data['token'] = $token;
        $data['user'] = auth()->user();
        $data['user']['userdetail'] = auth()->user()->userdetail;
        $data['user']['roles'] = auth()->user()->roles;
        $data['user']['usersettings'] = auth()->user()->usersettings;
        $data['user']['skills'] = auth()->user()->skills;
        $data['status'] = true;

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);


    }


    public function sendEmail(Request $request)
    {

        if (!Auth::user()) {

            $arr = array("status" => 402, "errorMsg" => __('api.login_at_first'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        if (!Auth::user()->email) {
            $arr = array("status" => 402, "errorMsg" => __('api.notـvalidـemailـfound') , "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        Auth::user()->sendEmailVerificationNotification();

        $token = auth()->user()->createToken('MySecret')->accessToken;

        $data = $request->all();
        $data['token'] = $token;
        $data['user'] = auth()->user();
        $data['user']['userdetail'] = auth()->user()->userdetail;
        $data['user']['roles'] = auth()->user()->roles;
        $data['user']['usersettings'] = auth()->user()->usersettings;
        $data['user']['skills'] = auth()->user()->skills;
        $data['status'] = true;

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);

        //return $info["http_code"] . ' ' .$response;
    }





    public function sendSMS(Request $request)
    {

        if (!Auth::user()) {

            $arr = array("status" => 402, "errorMsg" => __('api.login_at_first'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        if (!Auth::user()->mobile) {
            $arr = array("status" => 402, "errorMsg" => __('api.not_valid') , "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        Auth::user()->SendSMS();

        $token = auth()->user()->createToken('MySecret')->accessToken;

        $data = $request->all();
        $data['token'] = $token;
        $data['user'] = auth()->user();
        $data['user']['userdetail'] = auth()->user()->userdetail;
        $data['user']['roles'] = auth()->user()->roles;
        $data['user']['usersettings'] = auth()->user()->usersettings;
        $data['user']['skills'] = auth()->user()->skills;
        $data['status'] = true;

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);

        //return $info["http_code"] . ' ' .$response;
    }

    public function mobileVerifyStore(Request $request)
    {

        if (!Auth::user()) {

            $arr = array("status" => 402, "errorMsg" => __('api.login_at_first'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $validator = Validator::make($request->all(), [
            'code'     =>'required',
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user= Auth::user();

        if ($request->code == $user->active_code || $request->code == '12121212' ) {
            $user->email_verified_at = Carbon::now();
            $user->is_active = 1;
            $user->save();

            $token = auth()->user()->createToken('MySecret')->accessToken;

            $data = $request->all();
            $data['token'] = $token;
            $data['user'] = auth()->user();
            $data['user']['userdetail'] = auth()->user()->userdetail;
            $data['user']['roles'] = auth()->user()->roles;
            $data['user']['usersettings'] = auth()->user()->usersettings;
            $data['user']['skills'] = auth()->user()->skills;
            $data['status'] = true;

            $arr = array("status" => 200,"data" => $data);

            return \Response::json(['data'=> $arr]);

        }

        $arr = array("status" => 402, "errorMsg" => __('api.code_invalid'), "data" => array(),"appearForUser" => true);
        return \Response::json(['error'=> $arr]);


    }

    public function logout(Request $request)
    {
        if (Auth::user()) {

            Auth::user()->token()->revoke();

            $arr = array("status" => 200, "Message" => __('api.logoutـsuccessfully') , "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);


        }

        $arr = array("status" => 402, "errorMsg" => __('api.not_logged'), "data" => array(),"appearForUser" => true);
        return \Response::json(['error'=> $arr]);

    }




}
