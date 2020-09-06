@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
@endsection
@section('content')



    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">التنبيهات</h2>
                </div>

                <div class="col-12 bg-light pt-4 pb-4 notifactions rounded">


                    @if(count(Auth::user()->notifications))
                        @foreach(Auth::user()->notifications as $notification)
                            
                        <!-- notifaction -->
                        <div class="col-12 mb-2 pb-2 notifaction-item">
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-1 text-center">
                                    <img src="{{url($notification->data['image'] ?? 'images/research.png')}}" class="img-fluid">
                                </div>
                                <div class="col-sm-11">
                                    <h2 class="mb-1">{{ $notification->data['title'] ?? __('notification.undefined') }} <span class="pull-left">{{ $notification->created_at }}</span></h2>
                                    <p class="mb-1 p-0">{{ $notification->data['desc'] ?? __('notification.undefined') }}</p>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    @else
                        <p>لا يوجد اي إشعارات في الوقت الحالي</p>
                    @endif

                    
                </div>
  
            </div>
        </div>
    </div>





@endsection

@section('jquery')

@endsection

