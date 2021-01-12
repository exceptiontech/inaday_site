<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Requests;
use Auth;
use DB;
use Hash;
use Mail;
use Validator;
use Redirect;
use Form;
use App\Log;
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


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $type = $request->type;

        if ($type == 'services_provider') {
            $title = __('admin.services_provider');
        }elseif ($type == 'entrepreneur') {
            $title = __('admin.entrepreneur');
        }elseif ($type == 'student') {
            $title = __('admin.students');
        }elseif ($type == 'admin') {
            $title = __('admin.admins');
        }elseif ($type == 'manager') {
            $title = __('admin.managers');
        }elseif ($type == 'employee') {
            $title = __('admin.employees');
        }elseif ($type == 'content_editor') {
            $title = __('admin.content_editors');
        }else {
            $title = __('admin.users');
        }


        $users = User::whereHas('roles',function($q) use ($type){
                            $q->where('name', $type);
                        })->get();

        return view('admin.users.index')->withUsers($users)->withTitle($title);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            //'roles' => 'required'
        ]);



        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));



        if ($user) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'user-'.$user->id;
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));

        return  redirect::to('admin/users?type='.$user->roles->first()->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::findOrFail($id);

      if ($user->isServicesProvider() == 1) {

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

        return view('admin.users.services_provider_edit', compact('user','countries','jobtypes','skills','levels','prefers','costkinds','applykinds','averagekinds','rewardkinds','readinesskinds'));
      }elseif ($user->isEntrepreneur() == 1) {
        return view('admin.users.entrepreneur_edit')->withUser($user);
      }else {
        return view('admin.users.edit')->withUser($user);
      }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $type = $request->type;

        if (!Auth::user() ) {
            return redirect::to('/');
        }

        $user = User::findOrFail($id);
        if(!empty($request->password))
        {
            $this->validate($request,[
                'password'=> 'required|string|min:8|max:25'
            ]);
            $user->password = Hash::make($request->password);
        }
        $user->first_name=$request->first_name;
        $user->last_name=@$request->last_name;
        $user->mobile=@$request->mobile;
        $user->save();

        
        if (count($user->userdetail) > 0) {
            $userdetail = Userdetail::find($user->userdetail->first()->id);
        }else {
            $userdetail = new Userdetail;
        }

        $userdetail->user_id = $id;
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

                    Auth::user()->skills()->attach([$skill=> ['is_default'=>'1']]);
                }else {

                    $item = Skill::where('title', 'like', '%' . $skill . '%')->first();

                    if ($item) {
                        Auth::user()->skills()->attach($skill);
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


        if ($user->isServicesProvider() == 1) {
            $type = 'services_provider';
        }elseif ($user->isEntrepreneur() == 1) {
            $type = 'entrepreneur';
        }

        Session::flash('status', "info");
        Session::flash('message', __('admin.edit_success'));


        return  redirect::to('admin/users?type='.$type);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $type = $request->type;
        $user  = User::findOrFail($id);
        $user->delete();

        if ($user) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'user-'.$user->id;
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', "danger");
        Session::flash('message', __('admin.delete_success'));
        return  redirect::to('admin/users?type='.$type);
    }


}
