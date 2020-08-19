<?php

namespace App\Http\Controllers;

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
        return view('home')->withBeneficiaries($beneficiaries);
    }


    public function SearchIndex(Request $request)
    {


        $services = Service::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();

        $projects = Project::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();

        $pages = Page::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();

        $articles = Article::where('title','like','%'.$request['query'].'%')->orWhere('desc','like','%'.$request['query'].'%')->latest()->get();


        $users = User::whereHas('roles',function($q){
                            $q->where('name', 'services_provider');
                        })->where('name','like','%'.$request['query'].'%')->orWhere('first_name','like','%'.$request['query'].'%')->orWhere('last_name','like','%'.$request['query'].'%')->get();


        return view('front.search.index')->withServices($services)->withProjects($projects)->withUsers($users)->withArticles($articles)->withPages($pages);

    }


}
