<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Skill;
use Illuminate\Http\Request;
use App\Beneficiary;
use Auth;
use App\User;
use App\Project;
use App\Service;
use App\Page;
use App\Article;

use Redirect;
use Session;
use Validator;


class FrontController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {

        $beneficiaries = Beneficiary::all();
        $cities = City::where('country_id', 1)->where('is_active', 1)->get(['id','title']);
        $skills = Skill::where('is_active', 1)->get(['id','title']);
        return view('home')->withBeneficiaries($beneficiaries)->withCities($cities)->withSkills($skills);
    }


    public function reSendSMS()
    {
        if ( !Auth::user() ) {
            return redirect('/');
        }

        Auth::user()->SendSMS();

        Session::flash('status', __('admin.success'));
        Session::flash('message', 'تم ارسال كود جديد');
        return redirect::back();
    }


    public function mobileVerify()
    {
        if ( Auth::user()->isActive() ) {
            return redirect('/');
        }
        return view('mobile.verify');
    }

    public function mobileVerifyStore(Request $request)
    {

        if ( !Auth::user() ) {
            return redirect('/');
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

        if ($request->code == $user->active_code) {
            $user->is_active = 1;
            $user->save();

            Session::flash('status', __('admin.success'));
            Session::flash('message', 'تم التفعيل');
            return redirect::to('/user/'.Auth::user()->id);


        }


    }


    public function sendSMS()
    {

        return Auth::user()->SendSMS();

        $str = '0540437879';
        $number = '966'.substr($str, 1);

        $url = "https://www.msegat.com/gw/sendsms.php";
        $params = json_encode([
                "userName" => "inaday",
                "userSender" => "INADAY",
                "apiKey" => "7731c731642e783f2e6043091cd6d8a8",
            "msg" => "Hi , Your current balance is points",
            "numbers" => "966540437879",
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


        //return $info["http_code"] . ' ' .$response;
    }



    public function SearchIndex(Request $request , User $users)
    {
        $users = $users->newQuery();

        //check roles
        $role = 'services_provider';
        $users->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });

        // Services provider with uncomplete profile
        $users->whereHas('userdetailComplete');



        //check exists team member
        // $team = Auth::user()->team->id;
        // $users->whereDoesntHave('teams', function ($query) use ($team) {
        //         $query->where('team_id' , $team);
        //     });




        if ($request->targetskills) {
            $targetskills = $request->targetskills;

            $users->whereHas('skills', function ($query) use ($targetskills) {
                $query->whereIn('skill_id', $targetskills);
            });
        }

        if ($request->country_id) {

            $country_id = $request->country_id;

            $users->whereHas('userdetails', function ($query) use ($targetskills) {
                $query->where('country_id', $country_id);
            });
        }

        if ($request->title) {

            $name = $request->title;
            // $users->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');

            $users->whereHas('userdetails', function ($query) use ($name) {
                $query->where('position', 'like', '%' . $name . '%');
            });

        }


        if ($users) {

            if ($request->targetskills) {
                $targetskills = $request->targetskills;
            }else {
                $targetskills =  array();
            }

            $skills = Skill::where('is_active',1)->get();
            return view('front.search.list')->withUsers($users->latest()->paginate(15))->withSkills($skills)->withTargetskills($targetskills);
        }

    }


        //Eng/ Adel function

//     public function SearchIndex(Request $request)
//     {


//         $services = Service::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();
//         $userId = [];
//         foreach ($services as $service)
//         {
//             array_push($userId, $service->user_id);
//         }

// //        $projects = Project::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();
// //
// //        $pages = Page::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();
// //
// //        $articles = Article::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();

//         $users = User::whereHas('roles',function($q){
//                             $q->where('name', 'services_provider');
//                         })->whereIn('id',$userId)->paginate(15);


// //        $users = User::whereHas('roles',function($q){
// //                            $q->where('name', 'services_provider');
// //                        })->where('name','like','%'.$request['query'].'%')->orWhere('first_name','like','%'.$request['query'].'%')->orWhere('last_name','like','%'.$request['query'].'%')->get();

// //        return view('front.search.index')->withServices($services)->withProjects($projects)->withUsers($users)->withArticles($articles)->withPages($pages);
//         return view('front.search.list')->withServices($services)->withUsers($users);

//     }


}
