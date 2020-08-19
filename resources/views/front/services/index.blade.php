@extends('layouts.inner')
@section('title')
{{__('file.services')}}

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
                                <h2>حسب تصنيف الأقسام</h2>
                            </div>
                            <div class="block-content">

                                <div class="col-12">
                                @if (count($sections))
                                  @foreach ($sections as $section)
                                   <div class="check-item">
                                      <div class="chicksign">
                                         <label class="che-box">
                                         <input class="required" type="checkbox" id="experience" name="skills[]" value="1" aria-required="true"><span class="label-text">
                                         {{ @$section->title[App::getLocale()] }} <em>*</em></span>
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
                        <div class="services">


                            <!-- services -->
                        @if (count($services))
                            @foreach ($services as $service)
                            <div class="service col-12 pt-3 pb-2 mb-3">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <img class="img-fluid" src="{{ url('uploads/'.$service->img) }}" alt="{{ $service->user->first_name.' '.$service->user->last_name }}" title="{{ $service->user->first_name.' '.$service->user->last_name }}">
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-11 mb-3">
                                                <h2><a href="#">{{$service->title}}</a></h2>
                                            </div>
                                            <div class="col-sm-1">
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="row service_bar">
                                            
                                            <div class="col-sm-7">

                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <img src="images/19571f92333dd5fba2598f637b68739c.png" class="rounded-circle img-thumbnail img-fluid">
                                                        محمد المأمون
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span class="bg-light">تصميم المواقع</span>
                                                    </li>
                                                </ul>

                                            </div>
                                            <div class="col-sm-5 pt-2">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <a class="btn btn-secondary" href="#">{{ $service->cost}} {{trans('file.sr')}}</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="btn btn-primary" href="{{url('/services/'.$service->title)}}">{{__('file.service_details')}}</a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                             </div>

                            @endforeach
                            {{ $services->appends(request()->input())->links() }}
                            @else
                                <div class="alert alert-danger">
                                    <i class="fa fa-exclamation-triangle"></i> {{trans('file.no_services')}}
                                </div>
                          @endif
                            <!-- services -->
                            

                            
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
