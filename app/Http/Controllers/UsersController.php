<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Notifications\RegisterServicesProvider;
use App\Notifications\RegisterEntrepreneur;
use App\Notifications\UpdatedUser;

use Session;
use App\User;
use App\Country;
use App\Jobtype;
use App\Skill;
use App\Level;
use App\Prefer;
use App\Costkind;
use App\Applykind;
use App\Averagekind;
use App\Rewardkind;
use App\Readinesskind;
use App\Userdetail;
use App\Interview;
use App\Beneficiary;
use App\City;
use Auth;
use Socialite;
use URL;
use Redirect;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function ServicesProviderIndex()
    {
        return view('auth.services_provider');

    }
    public function EntrepreneurIndex()
    {
        return view('auth.entrepreneur');
    }




    public function register($type)
    {

        if ($type == 'services_provider') {

            $jobtypes = Jobtype::all();
            $skills = Skill::all();
            $levels = Level::all();
            $prefers= Prefer::all();
            $costkinds= Costkind::all();
            $applykinds= Applykind::all();
            $averagekinds= Averagekind::all();
            $rewardkinds= Rewardkind::all();
            $readinesskinds = Readinesskind::all();
            $countries = Country::all();
            $cities = City::all();

            if (Auth::user()) {
                return view('auth.logged_services_provider',compact('countries','jobtypes','skills','levels','prefers','costkinds','applykinds','averagekinds','rewardkinds','readinesskinds','cities'));
            }else{
                return view('auth.register_services_provider',compact('countries','jobtypes','skills','levels','prefers','costkinds','applykinds','averagekinds','rewardkinds','readinesskinds'));
            }

        }elseif ($type == 'entrepreneur') {

            return view('auth.register_entrepreneur');

        }elseif ($type == 'student') {

            return view('auth.student');

        }else {
            return '404';
        }

    }

    public function register_service_provider()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::findorfail($id);

        return view('front.user.show')->withUser($user);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {

        if (!Auth::user() || count(Auth::user()->roles) == 0 ) {
            return view('front.errors.denied');
        }

        $userdetail=UserDetail::where('user_id',Auth::id())->first();

        if (Auth::user()->isServicesProvider() == 1)
        {

            //return Auth::user()->isServicesProviderNotCompleted();

            if (!Auth::user()->isServicesProviderNotCompleted()) {
                return redirect('/account/profile/edit');
            }

            $jobtypes = Jobtype::all();
            $skills = Skill::all();
            $levels = Level::all();
            $prefers= Prefer::all();
            $costkinds= Costkind::all();
            $applykinds= Applykind::all();
            $averagekinds= Averagekind::all();
            $rewardkinds= Rewardkind::all();
            $readinesskinds = Readinesskind::all();
            $countries = Country::all();



            return view('front.profile.index',compact('userdetail','countries','jobtypes','skills','levels','prefers','costkinds','applykinds','averagekinds','rewardkinds','readinesskinds'));
        }elseif (Auth::user()->isEntrepreneur() == 1)
        {
            return view('front.profile.index_entrepreneur',compact('userdetail'));
        }else
        {
            abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {


        $jobtypes = Jobtype::all();
        $skills = Skill::all();
        $levels = Level::all();
        $prefers= Prefer::all();
        $costkinds= Costkind::all();
        $applykinds= Applykind::all();
        $averagekinds= Averagekind::all();
        $rewardkinds= Rewardkind::all();
        $readinesskinds = Readinesskind::all();
        $countries = Country::all();
        $cities = City::all();

        return view('front.profile.edit',compact('countries','jobtypes','skills','levels','prefers','costkinds','applykinds','averagekinds','rewardkinds','readinesskinds','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!Auth::user() ) {
            return redirect::to('/');
        }

        if (count(Auth::user()->userdetail) > 0) {
            $userdetail = Userdetail::find(Auth::user()->userdetail->first()->id);
        }else {
            $userdetail = new Userdetail;
        }

        $user = Auth::user();
        if(!empty($request['password']))
        {
            $this->validate($request,[
                'password'=> 'required|string|min:8|max:25'
            ]);
            $user->password = Hash::make($request['password']);
        }
        $user->first_name=$request->first_name;
        $user->last_name=@$request->last_name;
        $user->mobile=@$request->mobile;
        $user->save();

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
        $userdetail->save();

        $avater =  $request->avater;
        if (isset($avater)) {
            $destinationPath = 'uploads/users';
            $extension =  $avater->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $avater->move($destinationPath, $fileName);
            $userdetail->avater =  $destinationPath.'/'.$fileName;
        }

        $cv_file =  $request->cv_file;
        if (isset($cv_file)) {
            $destinationPath = 'uploads/users';
            $extension =  $cv_file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $cv_file->move($destinationPath, $fileName);
            $userdetail->cv_file =  $destinationPath.'/'.$fileName;
        }

        $userdetail->save();


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


        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new UpdatedUser(Auth::user()));
        } 

        return redirect::to('/user/'.Auth::user()->id);

        // if (Auth::user()->PassedInterview()) {
        //     return redirect::to('/');
        // }

        // // Create interview
        // $interview = new Interview;
        // $interview->user_id = Auth::user()->id;
        // $interview->skill_id = Auth::user()->DefaultSkill()->id;
        // $interview->total = 0;
        // $interview->is_passed = 0;
        // $interview->save();

        // return redirect::to('/account/interviews/'.$interview->id);

    }

    public function update_profile(Request $request)
    {

        if (!Auth::user() ) {
            return redirect::to('/');
        }
        $data=Auth::user();
        $this->validate($request,[
            'first_name' => 'required|string|max:255',
            'avater' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        if(!empty($request['password']))
        {
            $this->validate($request,[
                'password'=> 'required|string|min:8|max:25'
            ]);
            $data->password = Hash::make($request['password']);
        }
        $data->first_name=$request->first_name;
        $data->last_name=@$request->last_name;
        $data->mobile=@$request->mobile;
        $data->save();
        //update user details

        if (count(Auth::user()->userdetail) > 0) {
            $userdetail = Userdetail::where('user_id',Auth::id())->first();
        }else {
            $userdetail = new Userdetail();
            $userdetail->user_id = Auth::id();
        }

        if ($request->hasFile('avater')) {
            $destinationPath = 'uploads/users';
            $file = $request->file('avater');
            $file_name = date('Y_m_d_h_i_s_').$request->first_name.'.'.$file->getClientOriginalExtension();
            $filePath = $destinationPath. "/".  $file_name;
            $file->move($destinationPath, $file_name);
            @unlink($destinationPath.'/'.$data->img);
            $userdetail->avater = $destinationPath.'/'.$file_name;
        }
        if (Auth::user()->isServicesProvider() == 1)
        {
            if (isset($cv_file)) {
                $destinationPath = 'uploads/users';
                $extension =  $cv_file->getClientOriginalExtension();
                $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
                $upload_success = $cv_file->move($destinationPath, $fileName);
                $userdetail->cv_file =  $destinationPath.'/'.$fileName;
            }
            $userdetail->jobtype_id = $request->jobtype_id;
            $userdetail->level_id = $request->level_id;
            $userdetail->prefer_id = $request->prefer_id;
            $userdetail->costkind_id = $request->costkind_id;
            $userdetail->applykind_id = $request->applykind_id;
            $userdetail->averagekind_id = $request->averagekind_id;
            $userdetail->average_cost = $request->average_cost;
            $userdetail->rewardkind_id = $request->rewardkind_id;
            $userdetail->readinesskind_id = $request->readinesskind_id;
            //$userdetail->readiness_date = $request->readiness_date;
            //$userdetail->time_start = $request->time_start;
            $userdetail->brith_day = $request->brith_day;
            $userdetail->country_id = $request->country_id;
            $userdetail->city_id = $request->city_id;
            $userdetail->position = $request->position;
            $userdetail->notes = $request->notes;
            $userdetail->save();
        }else
        {
            $userdetail->save();
        }

        return redirect(route('account.profile'))->with('flash_message','تم تعديل بياناتك بنجاح');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function registration() {
        $beneficiaries = Beneficiary::all();
        return view('auth.registration')->withBeneficiaries($beneficiaries);
    }

    public function google(){

        Session::put('url', URL::Current());
        return Socialite::with('google')->stateless()->redirect();
    }

    public function googleRedirect( Request $request) {

        $url = Session::get('url');
        Session::forget('url');

        $return_user = Socialite::driver('google')->stateless()->user();



        if (str_contains($url, 'services_provider')) {

            $user = User::where('email',$return_user->email)->first();

            if(isset($user)) {
                $role = Role::where('name','services_provider')->first();
                $user->assignRole([$role->id]);

                Auth::login($user, true);

                if (!Auth::user()->userdetail) {
                    return redirect('/register/services_provider');
                }

                return redirect('/');

            }else {

                $user = New User;
                if ($return_user->name) {
                    $user->name = $return_user->name;
                }else {
                    $user->name = $return_user->user['name'];
                }

                if (isset($return_user->email)) {
                    $user->email = $return_user->email;
                }else {
                    $user->emails = $return_user->user['email'];
                }

                if (isset($return_user->user['given_name'])) {
                    $user->first_name = $return_user->user['given_name'];
                }

                if (isset($return_user->user['family_name'])) {
                    $user->last_name = $return_user->user['family_name'];
                }

                if (isset($return_user->mobile)) {
                    $user->mobile = $return_user->mobile;
                }
                $user->password = Hash::make($return_user->nickname);

                $user->save();

                $role = Role::where('name','services_provider')->first();
                $user->assignRole([$role->id]);

                $user->sendEmailVerificationNotification();
                $user->notify(new RegisterServicesProvider($user));

                Auth::login($user, true);

                return redirect('/account/profile');

            }


        }elseif (str_contains($url, 'entrepreneur')) {

            $user = User::where('email',$return_user->email)->first();

            if(isset($user)) {

                Auth::login($user, true);
                return redirect('/');

            }else {
                $user = New User;
                if ($return_user->name) {
                    $user->name = $return_user->name;
                }else {
                    $user->name = $return_user->user['name'];
                }

                if (isset($return_user->email)) {
                    $user->email = $return_user->email;
                }else {
                    $user->emails = $return_user->user['email'];
                }

                if (isset($return_user->user['given_name'])) {
                    $user->first_name = $return_user->user['given_name'];
                }

                if (isset($return_user->user['family_name'])) {
                    $user->last_name = $return_user->user['family_name'];
                }

                if (isset($return_user->mobile)) {
                    $user->mobile = $return_user->mobile;
                }
                $user->password = Hash::make($return_user->nickname);

                $user->save();
            }

            $role = Role::where('name','entrepreneur')->first();
            $user->assignRole([$role->id]);

            $user->sendEmailVerificationNotification();
            $user->notify(new RegisterEntrepreneur($user));

            Auth::login($user, true);
            return redirect('/');


        }elseif (str_contains($url, 'student')) {

            $user = User::where('email',$return_user->email)->first();

            if(isset($user)) {

                Auth::login($user, true);
                return redirect('/');

            }else {
                $user = New User;
                if ($return_user->name) {
                    $user->name = $return_user->name;
                }else {
                    $user->name = $return_user->user['name'];
                }

                if (isset($return_user->email)) {
                    $user->email = $return_user->email;
                }else {
                    $user->emails = $return_user->user['email'];
                }

                if (isset($return_user->user['given_name'])) {
                    $user->first_name = $return_user->user['given_name'];
                }

                if (isset($return_user->user['family_name'])) {
                    $user->last_name = $return_user->user['family_name'];
                }

                if (isset($return_user->mobile)) {
                    $user->mobile = $return_user->mobile;
                }
                $user->password = Hash::make($return_user->nickname);

                $user->save();

            }

            $role = Role::where('name','student')->first();
            $user->assignRole([$role->id]);
            $user->sendEmailVerificationNotification();

            Auth::login($user, true);
            return redirect('/');

        }elseif (str_contains($url, 'login')) {

            $user = User::where('email',$return_user->email)->first();

            if(isset($user)) {

                Auth::login($user, true);
                return redirect('/');

            }

            return redirect('/registration');
        }


        $user = User::where('email',$return_user->email)->first();

        if(isset($user)) {
            Auth::login($user, true);
            return redirect('/');

        }else {
            $user = New User;
            if ($return_user->name) {
                $user->name = $return_user->name;
            }else {
                $user->name = $return_user->user['name'];
            }
            if (isset($return_user->email)) {
                $user->email = $return_user->email;
            }else {
                $user->emails = $return_user->user['email'];
            }

            if (isset($return_user->user['given_name'])) {
                $user->first_name = $return_user->user['given_name'];
            }

            if (isset($return_user->user['family_name'])) {
                $user->last_name = $return_user->user['family_name'];
            }

            if (isset($return_user->mobile)) {
                $user->mobile = $return_user->mobile;
            }
            $user->password = Hash::make($return_user->nickname);

            $user->save();
            $user->sendEmailVerificationNotification();

        }

        Auth::login($user, true);

        return redirect('/');

    }


    public function twitter(){
        return Socialite::with('Twitter')->redirect();
    }

    public function twitterRedirect() {
        $return_user = Socialite::driver('Twitter')->user();

        return dd($return_user);

        $user = User::where('name',$return_user->nickname)->first();

        if($user) {

        }else {
            $user = New User;
            $user->name = $return_user->nickname;
            $user->email = $return_user->email;
            $user->fullname = $return_user->name;
            if (isset($return_user->mobile)) {
                $user->mobile = $return_user->mobile;
            }
            $user->password = Hash::make($return_user->nickname);
            $user->save();
            $user->sendEmailVerificationNotification();

        }

        Auth::login($user, true);
        return redirect('/');
    }


    public function facebook(){
        return Socialite::with('facebook')->redirect();
    }

    public function facebookRedirect() {
        $return_user = Socialite::driver('facebook')->user();

        return dd($return_user);

        $user = User::where('name',$return_user->nickname)->first();

        if($user) {

        }else {
            $user = New User;
            $user->name = $return_user->nickname;
            $user->email = $return_user->email;
            $user->fullname = $return_user->name;
            if (isset($return_user->mobile)) {
                $user->mobile = $return_user->mobile;
            }
            $user->password = Hash::make($return_user->nickname);
            $user->save();

            $user->sendEmailVerificationNotification();

        }

        Auth::login($user, true);
        return redirect('/');
    }


    public function notifications()
    {
        return Auth::user()->unreadNotifications;
    }

    public function getCities(Request $request){

        $cities = City::where('country_id', $request->country_id)->get();
        if (count($cities) > 0) {
            return response()->json($cities);
        }
    }

    public function account() {
        return view('front.profile.settings'); 
    }

    public function about($id)
    {
        $user = User::findorfail($id);
        return view('front.user.about')->withUser($user);
    }

    public function services($id)
    {
        $user = User::findorfail($id);
        return view('front.user.services')->withUser($user);
    }

    public function skills($id)
    {
        $user = User::findorfail($id);
        return view('front.user.skills')->withUser($user);
    }

    public function portfolios($id)
    {
        $user = User::findorfail($id);
        return view('front.user.portfolios')->withUser($user);
    }

    public function experiences($id)
    {
        $user = User::findorfail($id);
        return view('front.user.experiences')->withUser($user);
    }

    public function reviews($id)
    {
        $user = User::findorfail($id);
        return view('front.user.reviews')->withUser($user);
    }

    public function projects($id)
    {
        $user = User::findorfail($id);
        return view('front.user.projects')->withUser($user);
    }


}
