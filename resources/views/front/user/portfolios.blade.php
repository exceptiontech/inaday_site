@extends('layouts.inner')

@section('title')
  {{$user->first_name. ' ' .$user->last_name}}
@endsection


@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">الملف الشخصي</h2>
                </div>

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



                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="project">

                        @if (!empty($user->userdetail->notes))
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('profile.notes') }}</h2> 
                                       <p>{{ $user->userdetail->notes}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">معرض الاعمال</h2> 
                                       
                                        <ul class="list-inline m-0 flex-shrink-1">
                                        @if (count($user->portfolios))
                                            @foreach ($user->portfolios as $portfolio)
                                            <div class="position-relative">
                                                <img class="mr-2 img-icon120" src="{{url($portfolio->image)}}">
                                            </div>
                                            @endforeach
                                        @else
                                            <p>لا يوجد اي عمل مضاف</p>
                                        @endif
                                        </ul>

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
