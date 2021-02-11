@extends('layouts.inner')
@section('content')



    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">


                <div class="col-12 title">
                    @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())
                      <h2 class="text-white mb-5">ادارة الخدمات</h2>
                    @else
                      <h2 class="text-white mb-5">ادارة المشاريع</h2>
                    @endif
                </div>

                <div class="col-12 ">
                <div class="bg-light mt-5 pt-4 pb-4 profile notifactions rounded">
                    <div class="col-12  profile-head-menu mb-5">

                        @include('front.profile.parts.menu')
                    </div>


                    @if(count(Auth::user()->notifications))
                        @foreach(Auth::user()->notifications as $notification)
                            
                        <!-- notifaction -->
                        <div class="col-12 mb-2 pb-2 notifaction-item">
                            <div class="row d-flex align-items-center">
                                <div class="col-3 col-sm-1 text-center">
                                    <img src="{{url($notification->data['image'] ?? 'images/research.png')}}" class="img-fluid">
                                </div>
                                <div class="col-9 col-sm-11">
                                    <h2 class="mb-1">{{ $notification->data['title'] ?? __('notification.undefined') }} <span class="pull-left d-none d-sm-block">{{ $notification->created_at }}</span></h2>
                                    <p class="mb-1 p-0 ">{{ $notification->data['desc'] ?? __('notification.undefined') }}</p>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    @else
                        <div class="col-12 mb-2 pb-2 notifaction-item">
                            <p>لا يوجد اي إشعارات في الوقت الحالي</p>
                        </div>
                    @endif

                    
                </div>
                </div>
  
            </div>
        </div>
    </div>





@endsection

@section('jquery')

@endsection

