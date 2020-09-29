@extends('layouts.inner')


@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">الملف الشخصي</h2>
                </div>

                dddd

                <div class="row profile">
                    <!-- sidebar Begin -->
                    @include('front.user.parts.sidebar')
                    <!-- sidebar End -->


                <!-- Content Begin -->
                <div class="col-12 col-md-8 profile-content">

                    @if (Session::has('message'))
                      <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                            {{Session::get('message')}}
                      </div>
                    @endif


                    @if(!$user->userdetailComplete)
                    <div class="alert alert-info bg-dark ">
                        <span class="circle rounded-circle bg-dark text-center"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        
                        برجاء اكمال وتحديث الملف الشخصي لما له تأثير فعلي على طريقة عملك
                    </div>
                    @endif


                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="project">


                            <!-- project -->
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                      <h2 class="mb-3"> نبذة عني</h2>
                                      <p> {{ $user->userdetail->first()->notes ?? 'من فضلك قم بتحديث الملف الشخصي' }}</p>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="block projects col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">المشاريع</h2> 
                                
                                      @if(count($user->projects))
                                        @foreach($user->projects as $project)
                                        <div class="col-12 project pb-3 pt-2">
                                            <h2>{{$project->title}}</h2>

                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <ul class="list-inline m-0 flex-shrink-1">
                                                        <li class="list-inline-item">
                                                            @if($project->user )
                                                                @if(count($project->user->userdetail) > 0)
                                                                    @if($project->user->userdetail->first()->avater)
                                                                      <img src="{{ url($project->user->userdetail->first()->avater) }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                    @else
                                                                      <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                    @endif
                                                                @else
                                                                  <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" /> 
                                                                @endif
                                                            @else
                                                              <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />                                                             
                                                            @endif                                                             
                                                            {{$user->first_name. ' ' .$user->last_name}}
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <div class="bg-light pt-1 pb-1 p-2 ">
                                                            @if($project->section)
                                                              {{@$project->section->title[App::getLocale()]}} 
                                                            @else 
                                                              {{trans('file.without_section')}}
                                                            @endif
                                                            </div>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                            {{ Carbon\Carbon::parse(strtotime($project->created_at))->format('d-m-Y') }}
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                                            {{$project->offers->count()}}  عرض
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-sm-5 text-right">
                                                    <label class="btn btn-secondary rounded text-white" href="#">{{ $project->cost }} ريال</label>
                                                    <a class="btn btn-primary rounded" href="{{ url('/projects/'.$project->id) }}">تفاصيل المشروع</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                          <div class="book-details">
                                              <div class="col-sm-12">
                                                لا يوجد مشاريع لهذا الرائد حتى الان
                                              </div>
                                          </div>
                                      @endif


                                    </div>
                                </div>
                            </div>


                        </div> 

                    </div>
                </div>
                <!-- sidebar End -->
            </div>
        </div>
    </div>
  @section('jquery')
@endsection
@endsection
