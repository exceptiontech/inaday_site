@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <!-- sidebar Begin -->
            <div class="col-12 col-md-4 sidaber">
                <div class="bg-light rounded pt-3 pb-3 p-2">
                    <div class="author">
                        <div class="col-sm-12 d-flex align-items-center mb-5">
                            @if($project->user )
                                @if(count($project->user->userdetail) > 0)
                                    @if($project->user->userdetail->first()->avater)
                                      <img src="{{ url($project->user->userdetail->first()->avater) }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$project->title}}" title="{{$project->title}}" />
                                    @else
                                      <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$project->title}}" title="{{$project->title}}" />
                                    @endif
                                @else
                                  <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$project->title}}" title="{{$project->title}}" />
                                @endif
                            @else
                              <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$project->title}}" title="{{$project->title}}" />
                            @endif  
                            <div class="ml-2">
                                <span class="small">{{trans('file.project_owner')}}</span> 
                                <div class="mt-2 small">
                                    <h2>{{ $project->user->first_name.' '.$project->user->last_name }}</h2>                                    
                                </div>
                            </div>                   
                        </div>
                    </div>

                    <div class="project-info mb-5">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.project_status')}}</div>
                                <div class="col-6 p-0">
                                    
                                      @if($project->booking)
                                        <span class="bg-danger">{{trans('file.status_unavaliable')}}
                                        </span>
                                      @else 
                                        <span class="bg-success">
                                            {{@$project->status->title[App::getLocale()] ?? trans('file.without_status') }}
                                        </span> 
                                      @endif

                                 </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.category_section')}}</div>
                                <div class="col-6 p-0">
                                  <span class="">
                                      @if($project->section)
                                        {{@$project->section->title[App::getLocale()]}} 
                                      @else 
                                        {{trans('file.without_section')}}
                                      @endif
                                  </span> 
                                </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.project_budget')}}</div>
                                <div class="col-6 p-0">{{$project->cost}} {{trans('file.riyal')}}</div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.execution_time')}}</div>
                                <div class="col-6 p-0">{{$project->duration}}  {{trans('file.hour')}}  </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.number_of_offers')}}</div>
                                <div class="col-6 p-0">{{count($project->offers)}} {{trans('file.offers')}}</div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 contact_author align-bottom">
                        <a href="{{url('/account/messages/?user_id='.$project->user->id)}}" class="btn btn-primary btn-block mb-2">{{trans('file.contact_me')}}</a>
                        @guest
                        <p class="small">{{trans('file.must_looged')}}</p>
                        @endguest
                    </div>
                </div>

                @if(Auth::user())
                    @if(count($project->ModelLogs) > 0 && Auth::user()->id == $project->user->id || Auth::user()->isAdmin())
                    <div class="list-group p-0 mt-5">
                        @foreach($project->ModelLogs as $log)
                            @include('front.projects.parts.log')
                        @endforeach
                    </div>
                    @endif
                @endif

            </div>
            <!-- sidebar End -->

            <!-- Content Begin -->
            <div class="col-12 col-md-8">
                <div class="bg-light rounded pt-2 pb-3 p-2">
                    <div class="project">
                        <!-- project -->
                        <div class="block col-12 pt-3 pb-2 mb-1">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h2 class="mb-3">{{trans('file.project_title')}}</h2> 
                                    <p>{{$project->title}} </p>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                          
                                          <div id="socialHolder">
                                            <div id="socialShare" class=" share-group">
                                              <a data-toggle="dropdown" class="btn">
                                                   <i class="fa fa-share-alt"></i>
                                              </a>
                                              <ul class="dropdown-menu">
                                                  <li>
                                                    <a target="_blank" data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/share?url={{url('/projects/'.$project->title)}}&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" class="btn btn-twitter" >
                                                  <i class="fa fa-twitter"></i>
                                                </a>
                                                </li>
                                                <li>
                                                  <a target="_blank"  href="http://www.facebook.com/sharer.php?u={{url('/projects/'.$project->title)}}" class="btn btn-facebook" >
                                                  <i class="fa fa-facebook"></i>
                                                </a>
                                                </li>         
                                                <li>
                                                  <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{url('/projects/'.$project->title)}}" class="btn btn-linkedin" data-placement="left">
                                                  <i class="fa fa-linkedin"></i>
                                                </a>
                                                </li>
                                                <li>
                                                  <a  class="btn btn-mail" href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{url('/projects/'.$project->title)}}">
                                                  <i class="fa fa-envelope"></i>
                                                </a>
                                                </li>
                                              </ul>
                                            </div>
                                          </div>

                                        </li>
                                        @if(Auth::user())
                                        <li class="list-inline-item">
                                            @if(Auth::user()->ProjecthasFavorite($project->id))
                                                <a id="RemoveFromFav" class="updateFav updateFav{{$project->id}}" data-id="{{$project->id}}" data-type="project" href="#">
                                                <i class="fa fa-star starred" aria-hidden="true"></i></a>
                                            @else
                                                <a id="AddToFav" class="updateFav updateFav{{$project->id}}" data-id="{{$project->id}}"  data-type="project"  href="#">
                                                <i class="fa fa-star" aria-hidden="true"></i></a>
                                            @endif
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="block col-12 pt-3 pb-2 mb-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2 class="mb-3">{{trans('file.project_details')}}</h2> 
                                    <p>{!! $project->desc !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="block col-12 pt-3 pb-2 mb-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2 class="mb-4">{{trans('file.targeted_skills')}}</h2> 
                                    <div class="clearfix">
                                    @if(count($project->skills))
                                        <ul class="list-inline">
                                            @foreach($project->skills as $skill)
                                                <li class="list-inline-item">
                                                    <div class="bg-light p-2 rounded-lg mb-2">{{@$skill->title[App::getLocale()]}}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="block col-12 pt-3 pb-2 mb-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2 class="mb-3">{{trans('file.project_attach')}}</h2> 
                                </div>
                                <div class="col-sm-12">
                                    @if(count($project->files) > 0)
                                        <div class="row">
                                        @foreach($project->files as $file)
                                            <div class="col-sm-6">
                                                <a class="d-flex" download="download" href="{{url($file->url)}}">
                                                    <div class="col-4  bg-light shadow-sm text-center p-2 align-middle">
                                                        @if(pathinfo($file->url, PATHINFO_EXTENSION)  == 'png' || pathinfo($file->url, PATHINFO_EXTENSION) == 'jpg' || pathinfo($file->url, PATHINFO_EXTENSION) == 'jpeg')
                                                            <img class="img-fluid" src="{{url($file->url)}}">
                                                        @else
                                                            <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
                                                        @endif
                                                    </div>
                                                    <div class="col-8 " dir="ltr">
                                                     <p class="m-0">{{$file->name}}</p>
                                                     <p class="m-0">{{ Carbon\Carbon::parse($file->created_at)->format('d-m-Y ') ?? 'غير محدد'}}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                        </div>
                                    @else
                                        <p>{{trans('file.no_files')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    
                        @guest    
                        <!-- alert -->
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <p>{{trans('file.must_looged')}}</p>
                                <a class="btn btn-primary" href="{{url('/register')}}">{{trans('file.register')}}</a>
                            </div>
                        </div>

                        @else




                        @if(!$project->booking)

                        @if(count($project->offers)>0)
                        <div class="block col-12 pt-3 pb-5 mb-1">
                            <div class="col-sm-12">
                                <h2 class="mb-3">{{trans('file.offers')}}</h2> 
                            </div>
                            <div class=" comments">
                            @if($project->num_team == 1)
                              @foreach($project->offers as $offer)
                                <div class="col-12 pt-3 pb-3 comment mb-4">
                                    <div class="row info">
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <img src="{{ url($offer->user->userdetail->first()->avater ?? 'assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right">
                                            <div class="ml-2">
                                                <span>{{ $offer->user->first_name.' '.$offer->user->last_name }}</span> 
                                                <div class="m-0 small">
                                                    <span class="mr-2">{{ $offer->user->userdetail->first()->position ?? '' }}</span>
                                                    <span>{{trans('file.date')}} {{ $offer->created_at }}</span>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-4 mt-3 mt-lg-0 text-right">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="bg-light rounded p-1">{{ $offer->price }} {{trans('file.riyal')}} </span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="bg-light rounded p-1">{{ $offer->duration }} {{__('file.hour')}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p>{{ $offer->offer }}</p>

                                    @if(Auth::user() && $project->user_id == Auth::user()->id)

                                    <button type="button" class="btn btn-primary btn-block mb-2" data-toggle="modal" data-target="#service-{{$offer->id}}">
                                      {{__('file.approve')}}
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade custom-modal" id="service-{{$offer->id}}" tabindex="-1" role="dialog" aria-labelledby="service-{{$offer->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header  bg-secondary">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">
                                                {{__('file.book_offer')}} : {{$project->title}}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body pt-0 pb-0">

                                            <div class="row">
                                                <div class="col-12 col-sm-6 text-left p-3">
                                                    <h5>تفاصيل المشروع </h5>
                                                    <div class="row info-menu">
                                                        <div class="col-12 col-sm-12 ">
                                                            <div class="item">
                                                                <span>تصنيف المشروع :</span> {{$project->section->title[App::getLocale()] ?? ''}}
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-sm-6 ">
                                                            <div class="item">
                                                                <span>عدد الساعات :</span> {{$project->duration}}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6 ">
                                                            <div class="item">
                                                                <span>مقدم المشروع :</span> {{ $project->user->first_name.' '.$project->user->last_name }}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6 ">
                                                            <div class="item">
                                                                <span>اسم المشروع :</span> {{$project->title}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5 class="mt-4">اجمالي العرض: </h5>
                                                    <div class="row  info-menu">
                                                        <div class="col-12 col-sm-12">
                                                            <div class="item">
                                                                <span>السعر :</span> {{$offer->price}}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12">
                                                            <div class="item">
                                                                <span>الرسوم والضرائب :</span> {{$offer->getFees()}}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 ">
                                                            <div class="item">
                                                                <span>اجمالي السعر :</span> {{$offer->price + $offer->getFees()}}</div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12 col-sm-6 p-3 payments-section text-left" >

                                                    <h5 class="mb-4">اختر طريقة الدفع: </h5>

                                                    <form action="{{ url('pay_payment/'.$project->title.'/'.$project->id.'/'.$offer->id.'/charge') }}" method="post">
                                                          <input type="hidden" name="amount" value="{{ $offer->price}}" />
                                                          {{ csrf_field() }}
                                                          <button class="btn btn-white btn-block mb-2">
                                                            الدفع بواسطة
                                                              <img src="{{ url('/assets/images/visa.svg' )}}">
                                                          </button>
                                                      </form>


                                                    <form action="{{ url('paypal/'.$project->title.'/'.$project->id.'/'.$offer->id.'/charge') }}" method="post">
                                                        <input type="hidden" name="amount" value="{{ $offer->price}}" />
                                                        {{ csrf_field() }}
                                                          <button class="btn btn-white btn-block mb-2">الدفع بواسطة
                                                              <img src="{{ url('/assets/images/paypal.svg' )}}">
                                                          </button>
                                                    </form>

                                                </div>
                                            </div>



                                          </div>
                                        </div>
                                      </div>
                                    </div>



                                    @endif

                                </div>

                              @endforeach
                            @else
                            <div class=" comments">
                              @foreach($project->offers as $offer)

                                <div class="col-12 pt-3 pb-3 comment">
                                    <div class="row info">
                                        <div class="col-sm-8 d-flex align-items-center">
                                            <img src="{{ url($offer->user->team->image ?? 'assets/images/img3.jpg') }}" class="rounded-circle img-thumbnail img-fluid pull-right">
                                            <div class="ml-2">
                                                <span>{{ $offer->team->title }}</span> 
                                                <div class="m-0 small">
                                                    <span class="mr-2">مسئول الفريق : {{ $offer->user->first_name.' '.$offer->user->last_name }}</span>
                                                    <span>بتاريخ {{ $offer->created_at }}</span>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <span class="bg-light rounded p-1">{{ $offer->price }} ر.س</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span class="bg-light rounded p-1">{{ $offer->duration }} يوم</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p>{{ $offer->offer }}</p>

                                    @if(Auth::user() && $project->user_id == Auth::user()->id)
                                    <form action="{{ url('paypal/'.$project->title.'/'.$project->id.'/'.$offer->id.'/charge') }}" method="post">
                                        <input type="hidden" name="amount" value="{{ $offer->price}}" />
                                        {{ csrf_field() }}
                                        <button class="btn btn-secondary btn-block">{{__('file.approve')}}</button>
                                    </form>

                                    @endif

                                </div>


                                </div>
                              @endforeach
                            @endif

                        @else

                          @if(Auth::user() && Auth::user()->isServicesProvider())

                            @if($project->num_team == 1)
                                <div class="alert alert-success">
                                    {{trans('file.be_the_first_services_provider_add_offer')}}
                                </div>
                            @else
                              <div class="alert alert-info">{{trans('file.this_project_for_teams')}}
                              </div>

                            @endif

                          @else
                            <div class="col-12 mt-5">
                                <div class="alert alert-info">
                                    {{trans('file.no_offer_at_this_time')}} 
                                </div>
                            </div>
                          @endif
                        </div>
                        @endif




                        @if(Auth::user() && Auth::user()->isServicesProvider() &&  $project->num_team == 1)
                        <div class=" projects">


                        <div class="block col-12 pt-3 pb-2 mb-3 border-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2 class="mb-3 dark">إضافة العروض</h2> 
                                </div>
                                <div class="col-sm-12">

                                @if (Session::has('message'))
                                <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                      <h6>{{Session::get('message')}}</h6>
                                </div>
                                @endif


                                @if(count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissable" >
                                            <button type="button" class="close p-0" data-dismiss="alert" aria-hidden="true">×</button>
                                            {{ $error}}
                                        </div>
                                    @endforeach
                                @endif


                                {{ Form::open(['action' => 'OfferController@store']) }}
                                <div class="row mb-3">

                                  <div class="col-sm-6 form-group">
                                    <label>{{trans('file.price')}}<em>* </em></label>
                                    <input class="form-control" type="text" name="price" placeholder="{{trans('file.add_your_offer_price_to_this_project')}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                    <input class="form-control" type="hidden" name="project_id" value="{{$project->id}}" >
                                  </div>
                                  <div class="col-sm-6 form-group">
                                    <label>{{trans('file.duration')}}<em>* </em></label>
                                    <input class="form-control" type="text" name="duration" placeholder="{{trans('file.add_your_offer_duration_to_this_project')}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                  </div>
                                </div>
                                <div class="row mb-3">
                                  <div class="col-sm-12 form-group">
                                    <label>{{trans('file.offer_details')}}<em>* </em></label>
                                    <textarea class="form-control" name="offer" placeholder="{{trans('file.add_your_offer_desc_to_this_project')}}"></textarea>
                                  </div>
                                </div>
                                <div class="row mb-3">
                                  <div class="col-sm-12 form-group">

                                    {!! Form::submit(trans('file.addoffer'), array('class'=>'btn btn-primary')) !!}
                                  </div>
                                </div>
                                {{ Form::close() }}

                                </div>
                            </div>
                        </div>
                        </div>
                        @else
                          @if(Auth::user() &&  Auth::user()->isServicesProvider() && count(Auth::user()->myteams) > 0)
                            <div class="projects">
                            <div class="block col-12 pt-3 pb-2 mb-3 border-0">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3 dark">اضافة العروض</h2> 
                                    </div>
                                    <div class="col-sm-12">

                                    {{ Form::open(['action' => 'OfferController@store']) }}

                                    <div class="row mb-3">
                                        <div class="col-12">
                                        <label>{{trans('file.team')}}<em>* </em></label>
                                        {!! Form::select('team_id',Auth::user()->myteams->pluck('title','id'), null,['required', 'class' => 'form-control']) !!} 
                                        </div>
                                        <div class="col-sm-6 inpudata">
                                          <label>{{trans('file.price')}}<em>* </em></label>
                                          <input class="form-control" type="text" name="price" placeholder="{{trans('file.add_your_offer_price_to_this_project')}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                          <input class="form-control" type="hidden" name="project_id" value="{{$project->id}}" >
                                        </div>
                                        <div class="col-sm-6 inpudata">
                                          <label>{{trans('file.duration')}}<em>* </em></label>
                                          <input class="form-control" type="text" name="duration" placeholder="{{trans('file.add_your_offer_duration_to_this_project')}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 inpudata">
                                          <label>{{trans('file.offer_details')}}<em>* </em></label>
                                          <textarea class="form-control" name="offer" placeholder="{{trans('file.add_your_offer_desc_to_this_project')}}"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 inpudata">

                                        {!! Form::submit(trans('file.addoffer'), array('class'=>'btn btn-primary')) !!}
                                        </div>
                                    </div>
                                    {{ Form::close() }}

                                    </div>
                                </div>
                            </div>
                            </div>
                          @endif

                        @endif


                        @else
                            <div class="col-12 mt-5">
                                <div class="alert alert-info">
                                    {{trans('file.not_available_right_now')}} 
                                </div>
                            </div>
                        @endif



                           
             

                            </div>
                        </div>


                        @endguest
                    </div> 
                </div>
            </div>
            <!-- sidebar End -->
        </div>
    </div>
</div>
@endsection



@section('jquery')
<script type="text/javascript">
    $(".updateFav").click(function(event) {
        event.preventDefault();

        var data = {'id' : $(this).data("id"),'type' : $(this).data("type")};

        $.ajax({    
            type  : 'get',
            url   : '{!!URL::route('updateFavorite')!!}',
            dataType: 'json',
            data  : data ,      
            success:function(data){

                console.log(data.result);

                if (data.result == 'done') {
                    $('.updateFav .fa').addClass('starred');
                }else {
                    $('.updateFav .fa').removeClass('starred');
                }
            },
        error:function(data){
            console.log(data.err)
        }
      });
    });   


</script>

@endsection

