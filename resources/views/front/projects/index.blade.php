@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <!-- sidebar Begin -->
            <div class="col-12 col-md-4">
                <div class="bg-light rounded pt-3 pb-3 p-2">
                    <!-- block Begin -->
                    <div class="block mb-4">
                        <div class="block-title mb-3">
                            <h2>{{trans('file.category')}}</h2>
                        </div>
                        <div class="block-content">
                            <div class="col-12">
                              @if (count($skills))
                                @foreach ($skills as $skill)
                                  <div class="check-item">
                                    <div class="chicksign">
                                        <label class="che-box">
                                        <input class="required" type="checkbox" id="experience" name="skills[]" value="1" aria-required="true"><span class="label-text">
                                          {{ @$skill->title[App::getLocale()] }} <em>*</em></span>
                                        </label>
                                    </div>
                                  </div>
                                @endforeach
                              @endif
                            </div>
                        </div>
                    </div>
                    <!-- block End -->

                    <!-- block Begin -->
                    <div class="block mb-4">
                        <div class="block-title mb-3">
                            <h2>حسب الكلمات المفتاحية</h2>
                        </div>
                        <div class="block-content">
                            dddddd
                        </div>
                    </div>
                    <!-- block End -->
                </div>
            </div>
            <!-- sidebar End -->

            <!-- Content Begin -->
            <div class="col-12 col-md-8">
                <div class="bg-light rounded pt-2 pb-3 p-2">
                    <div class="projects">
                        <!-- project -->
                        @if (count($projects))
                            @foreach ($projects as $project)
                                <div class="project col-12 pt-3 pb-2 mb-3">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <h2 class="mb-4"><a href="{{ url('/projects/'.$project->id) }}">{{ $project->title }}</a></h2> 
                                        </div>
                                        <div class="col-sm-1">
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-9">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                  @if($project->user )
                                                      @if(count($project->user->userdetail) > 0)
                                                          @if($project->user->userdetail->first()->avater)
                                                            <img src="{{ url($project->user->userdetail->first()->avater) }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                            {{ $project->user->first_name.' '.$project->user->last_name }}
                                                          @else
                                                            <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                            {{ $project->user->first_name.' '.$project->user->last_name }}
                                                          @endif
                                                      @else
                                                        <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                        {{ $project->user->first_name.' '.$project->user->last_name }}
                                                      @endif
                                                  @else
                                                    <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                    {{ $project->user->first_name.' '.$project->user->last_name }}
                                                  @endif  
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
                                                    {{ $project->created_at }} 
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                                    10 عرض
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <a class="btn btn-primary btn-block rounded" href="{{ url('/projects/'.$project->id) }}">{{trans('file.progect_details')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $projects->appends(request()->input())->links() }}

                            @else
                              <div class="alert alert-danger">
                                  <i class="fa fa-exclamation-triangle"></i> {{trans('file.there_are_no_projects')}}
                              </div>
                        @endif
                    </div> 

                    <!-- pagination begin -->
                    <div class="col-12"> 
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                              <a class="page-link" href="#" tabindex="-1"><<</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                              <a class="page-link" href="#">>></a>
                            </li>
                          </ul>
                        </nav>
                    </div>
                    <!-- pagination end -->
                </div>
            </div>
            <!-- sidebar End -->
        </div>
    </div>
</div>
@endsection
