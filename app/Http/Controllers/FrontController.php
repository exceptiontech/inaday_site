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


    public function SearchIndex(Request $request)
    {


        $services = Service::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();
        $userId = [];
        foreach ($services as $service)
        {
            array_push($userId, $service->user_id);
        }

//        $projects = Project::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();
//
//        $pages = Page::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();
//
//        $articles = Article::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();

        $users = User::whereHas('roles',function($q){
                            $q->where('name', 'services_provider');
                        })->whereIn('id',$userId)->paginate(15);


//        $users = User::whereHas('roles',function($q){
//                            $q->where('name', 'services_provider');
//                        })->where('name','like','%'.$request['query'].'%')->orWhere('first_name','like','%'.$request['query'].'%')->orWhere('last_name','like','%'.$request['query'].'%')->get();

//        return view('front.search.index')->withServices($services)->withProjects($projects)->withUsers($users)->withArticles($articles)->withPages($pages);
        return view('front.search.list')->withServices($services)->withUsers($users);

    }


}
