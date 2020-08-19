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
                        <div class="col-sm-8 d-flex align-items-center mb-5">
                            @if($project->user )
                                @if(count($project->user->userdetail) > 0)
                                    @if($project->user->userdetail->first()->avater)
                                      <img src="{{ url($project->user->userdetail->first()->avater) }}" class="rounded-circle img-thumbnail img-fluid pull-right" alt="{{$project->title}}" title="{{$project->title}}" />
                                    @else
                                      <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right" alt="{{$project->title}}" title="{{$project->title}}" />
                                    @endif
                                @else
                                  <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right" alt="{{$project->title}}" title="{{$project->title}}" />
                                @endif
                            @else
                              <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right" alt="{{$project->title}}" title="{{$project->title}}" />
                            @endif  
                            <div class="ml-2">
                                <span class="small">{{trans('file.progect_owner')}}</span> 
                                <div class="mt-2 small">
                                    <h2>{{ $project->user->first_name.' '.$project->user->last_name }}</h2>                                    
                                </div>
                            </div>                   
                        </div>
                    </div>

                    <div class="project-info mb-5">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.progect_status')}}</div>
                                <div class="col-6 p-0"><span class="bg-success">مفتوح</span> </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.category_section')}}</div>
                                <div class="col-6 p-0">
                                  <span class="bg-light">
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
                                <div class="col-6 p-0">وقت التنفيذ </div>
                            </li>
                            <li class="list-group-item d-flex">
                                <div class="col-6 p-0 text-dark">{{trans('file.number_of_offers')}}</div>
                                <div class="col-6 p-0">3 {{trans('file.offers')}}</div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 contact_author align-bottom">
                        <a href="#" class="btn btn-primary btn-block mb-2">{{trans('file.contact_the_project_owner')}}</a>
                        <p class="small">{{trans('file.you_must_log_in_first_to_use_the_platforms_services')}}</p>
                    </div>
                </div>
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
                                    <h2 class="mb-3">{{$project->title}}</h2> 
                                    <p>تصميم موقع لشركة مطاعم واجهة للشركة ومبيعات الوجبات</p>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><i class="fa fa-share-alt" aria-hidden="true"></i></li>
                                        <li class="list-inline-item"><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="block col-12 pt-3 pb-2 mb-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2 class="mb-3">{{trans('file.progect_details')}}</h2> 
                                    <p>{!! \Illuminate\Support\Str::words($project->desc,350,'....')  !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="block col-12 pt-3 pb-2 mb-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2 class="mb-3">{{trans('file.targeted_skills')}}</h2> 
                                    @if(count($project->skills))
                                        <ul class="list-inline">
                                            @foreach($project->skills as $skill)
                                                <li class="list-inline-item">
                                                    <span class="bg-light p-2 rounded-lg">{{@$skill->title[App::getLocale()]}}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="block col-12 pt-3 pb-2 mb-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h2 class="mb-3">{{trans('file.project_attach')}}</h2> 
                                </div>
                                <div class="col-sm-12">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        @if(!$project->booking)
                            @if(count($project->offers)>0)
                                @if($project->num_team == 1)
                                    @foreach($project->offers as $offer)
                                        <div class="block col-12 pt-3 pb-2 mb-1">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h2 class="mb-4">العروض المقدمة</h2> 
                                                </div>
                                                <div class="col-12 pt-3 pb-3 comment">
                                                    <div class="row info">
                                                        <div class="col-sm-8 d-flex align-items-center">
                                                            <img src="images/19571f92333dd5fba2598f637b68739c.png" class="rounded-circle img-thumbnail img-fluid pull-right">
                                                            <div class="ml-2">
                                                                <span>محمد الغالي</span> 
                                                                <div class="m-0 small">
                                                                    <span class="mr-2">مقدم خدمة</span>
                                                                    <span>بتاريخ 10/11/2019</span>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-sm-4 text-right">
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item">
                                                                    <span class="bg-light rounded p-1">1500 ر.س</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <span class="bg-light rounded p-1">10 ساعة</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <p>السلام عليكم ورحمة الله وبركاته ، قرأت المطلوب وبإمكاني توفير كل ما يتطلبه موقع ، بالمُميزات الأتية : تصميم عالي الجودة ، عصري وسلس بأحدث تقنيات لغات التصميم</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @else
                                      @foreach($project->offers as $offer)
                                        @if($offer->user_id == Auth::user()->id)
                                            <div class="block col-12 pt-3 pb-2 mb-3 border-0">
                                              {{ Form::open(['action' => 'OfferController@store']) }}
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h2 class="mb-3 dark">اضافة العروض</h2> 
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <form>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <label for="inputEmail4">{{trans('file.price')}} <em>* </em></label>
                                                                    <input type="text" class="form-control" placeholder="{{trans('file.price')}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                                                </div>
                                                                <div class="col-3">
                                                                    <label for="inputEmail4">{{trans('file.project_time_duration')}} <em>* </em></label>
                                                                    <input type="text" class="form-control" placeholder="{{trans('file.project_time_duration')}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                                                </div>
                                                                <div class="col-3">
                                                                    <label for="inputEmail4">{{trans('file.day_hour')}} <em>* </em></label>
                                                                    <select class="form-control" name="type">
                                                                        <option value="d">{{trans('file.day')}}</option>
                                                                        <option value="h">{{trans('file.hour')}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label for="inputEmail4">{{trans('file.offer_details')}} <em>* </em></label>
                                                                    <textarea class="form-control" placeholder="{{trans('file.offer_details')}}"></textarea> 
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                  {!! Form::submit(trans('file.addoffer'), array('class'=>'btn btn-primary')) !!}
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                              {{ Form::close() }}
                                            </div>
                                        @endif
                                      @endforeach
                                @endif
                            @endif
                        @endif
                                
                        <!-- alert -->
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <p>يتوجب عليك تسجيل الدخول أولاً لكي تتمكن من تقديم عرضك لهذا المشروع</p>
                                <a class="btn btn-primary" href="#">تسجيل</a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <!-- sidebar End -->
        </div>
    </div>
</div>
@endsection
