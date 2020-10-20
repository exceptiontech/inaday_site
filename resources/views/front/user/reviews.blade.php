@extends('layouts.inner')

@section('title')
  {{$user->first_name. ' ' .$user->last_name}}
@endsection


@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{ __('file.profile') }}</h2>
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


                    @if(!$user->userdetailComplete)
                    <div class="alert alert-info bg-dark ">
                        <span class="circle rounded-circle bg-dark text-center"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        
                        {{ __('file.completeprofile') }}
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
                                       <h2 class="mb-3">{{ __('file.reviews') }}</h2> 
                                       
                                        <div class="row">
                                        @if (count($user->reviews))
                                            @foreach ($user->skills as $review)
                                                <div class="col-12 mb-1">
                                                    {{$review->review}}
                                                </div>
                                            @endforeach
                                        @endif
                                        </div>

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
