<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Userdetail;
use App\Interview;
use App\Skill;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Redirect;
use Illuminate\Auth\Events\Registered;
use URL;
use Auth;

use App\Usersettings;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_type' => ['required', 'string'],
            'first_name' => ['required', 'string', 'min:3','alpha'],
            'last_name' => ['required', 'string', 'min:3','alpha'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8',
                        'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
             'confirmed'],
            'mobile' =>['required','digits:10']
            // 'brith_day' => ['required', 'date_format:Y-m-d|before:today'],
            // 'average_cost' => ['regex:/^\s*(?=.*[1-9])\d*(?:\.\d{1,2})?\s*$/'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
    }





    public function register(Request $request)
    {
//        return $request;
//
//        if($request->day < 10 ) {
//            $request->day = '0'.$request->day;
//        }
//
//        if($request->month < 10 ) {
//            $request->month = '0'.$request->month;
//        }

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $user->sendEmailVerificationNotification();

        $url = URL::previous();

        if($request->user_type == "services_provider"){

            $role = Role::where('name','services_provider')->first();
            $user->assignRole([$role->id]);

            if (count($user->userdetail) > 0) {
                $userdetail = Userdetail::find(Auth::user()->userdetail->id);
            }else {
                $userdetail = new Userdetail;
            }

            if (Auth::user()) {
                $userdetail->user_id = Auth::user()->id;
            }else {
                $userdetail->user_id = $user->id;
            }

//            $userdetail->jobtype_id = $request->jobtype_id;
//            $userdetail->level_id = $request->level_id;
//            $userdetail->prefer_id = $request->prefer_id;
//            $userdetail->costkind_id = $request->costkind_id;
//            $userdetail->applykind_id = $request->applykind_id;
//            $userdetail->averagekind_id = $request->averagekind_id;
//            $userdetail->average_cost = $request->average_cost;
//            $userdetail->rewardkind_id = $request->rewardkind_id;
//            $userdetail->readinesskind_id = $request->readinesskind_id;
//            $userdetail->readiness_date = $request->readiness_date;
//            $userdetail->time_start = $request->time_start;
//            $userdetail->brith_day = $request->year.'-'.$request->month.'-'.$request->day;
//            $userdetail->country_id = $request->country_id;
//            $userdetail->position = $request->position;
//            $userdetail->notes = $request->notes;
//            $userdetail->save();
//
//            $avater =  $request->avater;
//            if (isset($avater)) {
//                $destinationPath = 'uploads/pages';
//                $extension =  $avater->getClientOriginalExtension();
//                $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
//                $upload_success = $avater->move($destinationPath, $fileName);
//                $userdetail->avater =  $destinationPath.'/'.$fileName;
//            }
//
//            $cv_file =  $request->cv_file;
//            if (isset($cv_file)) {
//                $destinationPath = 'uploads/pages';
//                $extension =  $cv_file->getClientOriginalExtension();
//                $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
//                $upload_success = $cv_file->move($destinationPath, $fileName);
//                $userdetail->cv_file =  $destinationPath.'/'.$fileName;
//            }
//
//            $userdetail->save();
//
//            $skills = $request->skills;
//
//            foreach ($skills as $skill) {
//
//                if (is_numeric($skill) && $skill > 0) {
//                    $user->skills()->attach([$skill=> ['is_default'=>'1']]);
//                }else {
//
//                    $item = Skill::where('title', 'like', '%' . $skill . '%')->first();
//
//                    if ($item) {
//                        $user->skills()->attach($skill);
//                    }else {
//
//                        $title = array();
//                        $title['ar'] = $skill;
//                        $new_skill = new Skill;
//                        $new_skill->title = $title;
//                        $new_skill->slug = $skill;
//                        $new_skill->is_active = 0;
//                        $new_skill->save();
//                        $user->skills()->attach($new_skill);
//                    }
//
//                }
//
//            }
//
//
//            // Create interview
//
//            $interview = new Interview;
//            $interview->user_id = $user->id;
//            $interview->skill_id = $user->DefaultSkill()->id;
//            $interview->total = 0;
//            $interview->is_passed = 0;
//            $interview->save();

            $this->guard()->login($user);

//            if (Auth::user()->PassedInterview()) {
//                return redirect::to('/');
//            }

            return redirect::to('email/verify');

        }elseif ($request->user_type == "entrepreneur") {

            $role = Role::where('name','entrepreneur')->first();
            $user->assignRole([$role->id]);

        }elseif (str_contains($url, 'student')) {

            $role = Role::where('name','student')->first();
            $user->assignRole([$role->id]);

        }

        $user->notification_preference = 'mail,database';

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


        $this->guard()->login($user);

        return redirect::to('/');



        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new Response('', 201)
                    : redirect($this->redirectPath());
    }


}
