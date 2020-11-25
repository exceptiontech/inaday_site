@extends('layouts.inner')


@section('content')
    <div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">البحث</h2>
                </div>


                <!-- sidebar Begin -->
                <div class="col-12 col-md-4">
                    <div class="bg-light rounded pt-3 pb-3 p-2">

                        {{ Form::open(['action' => 'FrontController@SearchIndex','method' => 'get']) }}
                        <!-- block Begin -->
                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <h2>حسب تصنيف الأقسام</h2>
                            </div>
                            <div class="block-content">

                                <div class="col-12">

                                    @foreach($skills as $skill)
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                            <input @if(in_array($skill->id, $targetskills )) checked="checked" @endif  name="targetskills[]" type="checkbox" value="{{$skill->id}}"> <span class="label-text">
                                              {{$skill->title[App::getLocale()]}} <em>*</em></span>
                                            </label>
                                        </div>
                                    </div>

                                    @endforeach

                                </div>



                            </div>
                        </div>
                        <!-- block End -->

                        <!-- block Begin -->
                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <h2>حسب العضو</h2>
                            </div>
                            <div class="block-content">
                                <div class="col-12">
                                {!!Form::text('title', Request::get('title'), ['id' => 'name','class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <!-- block End -->
                        <div class="col-12">

                          {!! Form::button(trans('admin.search'), array('class'=>'btn btn-block btn-success','id'=>'search-button', 'type'=>'submit')) !!}
                        </div>
                        
                        {{ Form::close() }}


                    </div>
                </div>
                <!-- sidebar End -->


                <!-- Content Begin -->
                <div class="col-12 col-md-8">
                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="row">

                          @if (count($users))
                            @foreach ($users as $user)
                              <!-- services provider begin  -->
                              <div class="col-12 col-md-4 mb-5 mt-5 provider-block">
                                  <div class="bg-light rounded text-center">
                                      <img class="w-50 mt-n5 rounded-circle" src="{{ url($user->userdetail->first()->avater ?? 'assets/images/logo.png') }}" alt="{{$user->first_name .' '. $user->last_name}}" height="107" >
                                      <div class="text p-2 pt-0">
                                          <h2 class="mb-3">  {{$user->first_name .' '. $user->last_name}} </h2>
                                          <p class="position">  {{ $user->userdetail->first()->position ?? '' }}</p>
                                          <p class="location">
                                              {{ $user->userdetail->first()->country->title[App::getLocale()] ?? 'دولة غير محددة'}} / {{ $user->userdetail->first()->city->title[App::getLocale()] ?? 'مدينة غير محددة '}}

                                          </p>

                                            @if(count($user->skills))
                                            <ul class="list-inline">
                                            @foreach($user->skills as $skill)
                                              <li class="list-inline-item">{{$skill->title[App::getLocale()]}}  </li>
                                            @endforeach
                                            </ul>
                                            @else
                                              {{__('file.no_skills')}}
                                            @endif
                                            <a class="btn btn-block btn-primary mt-4" href="{{url('/account/messages/?user_id=/'.$user->id)}}">مراسلة العضو  </a>

                                      </div>
                                  </div>
                              </div>
                              <!-- services provider end  -->
                            @endforeach
                            <div class="col-12">
                              {{ $users->appends(request()->input())->links() }}
                            </div>

                          @else
                            <div class="col-12">
                              <div class="alert alert-danger">
                                  <i class="fa fa-exclamation-triangle"></i> {{trans('file.no_services_providers_right_now')}}
                              </div>
                            </div>
                          @endif





                        </div> 
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection