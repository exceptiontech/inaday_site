@extends('layouts.inner')
@section('title')
{{__('file.services')}}

@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">الملف الشخصي</h2>
                </div>
                <!-- sidebar Begin -->
                <div class="col-12 col-md-4">
                    <div class="bg-light rounded pt-3 pb-3 p-2">

                        {{ Form::open(['action' => 'ServiceController@index','method' => 'get']) }}




                        <!-- block Begin -->
                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <h2>حسب المهارة</h2>
                            </div>
                            <div class="block-content">

                                <div class="col-12">
                                @if (count($skills))
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
                                @endif
                                </div>

                            </div>
                        </div>
                        <!-- block End -->


                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <h2>حسب تصنيف الأقسام</h2>
                            </div>
                            <div class="block-content">

                                <div class="col-12">
                                  {!!Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), Request::get('section_id'), ['class' => 'form-control']) !!}

                                </div>

                            </div>
                        </div>



                        <!-- block Begin -->
                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <h2>حسب اسم الخدمة</h2>
                            </div>
                            <div class="block-content">

                                <div class="col-12">
                                  {!!Form::text('title', Request::get('title'), ['class' => 'form-control']) !!}
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
                        <div class="services">


                            <!-- services -->
                        @if (count($services))
                            @foreach ($services as $service)
                            <div class="service col-12 pt-3 pb-2 mb-3">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <img class="img-fluid" src="{{ url($service->img ?? 'assets/images/logo.png') }}" alt="{{ $service->title }}" title="{{ $service->title }}">
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-10 mb-3">
                                                <h2><a href="{{url('/services/'.$service->title)}}">{{$service->title}}</a></h2>
                                            </div>
                                            <div class="col-sm-2">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                              
                                              <div id="socialHolder">
                                                <div id="socialShare" class=" share-group">
                                                  <a data-toggle="dropdown" class="btn">
                                                       <i class="fa fa-share-alt"></i>
                                                  </a>
                                                  <ul class="dropdown-menu">
                                                      <li>
                                                        <a target="_blank" data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/share?url={{url('/services/'.$service->title)}}&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" class="btn btn-twitter" >
                                                      <i class="fa fa-twitter"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a target="_blank"  href="http://www.facebook.com/sharer.php?u={{url('/services/'.$service->title)}}" class="btn btn-facebook" >
                                                      <i class="fa fa-facebook"></i>
                                                    </a>
                                                    </li>         
                                                      <li>
                                                      <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{url('/services/'.$service->title)}}" class="btn btn-linkedin" data-placement="left">
                                                      <i class="fa fa-linkedin"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a  class="btn btn-mail" href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{url('/services/'.$service->title)}}">
                                                      <i class="fa fa-envelope"></i>
                                                    </a>
                                                    </li>
                                                  </ul>
                                                </div>
                                              </div>

                                            </li>

                                             <li class="list-inline-item">
                                                @if(Auth::user())
                                                @if(Auth::user()->ServicehasFavorite($service->id))
                                                    <a id="RemoveFromFav" class="updateFav updateFav{{$service->id}}" data-id="{{$service->id}}" href="#">
                                                    <i class="fa fa-star starred" aria-hidden="true"></i></a>
                                                @else
                                                    <a id="AddToFav" class="updateFav updateFav{{$service->id}}" data-id="{{$service->id}}"  href="#">
                                                    <i class="fa fa-star-o" aria-hidden="true"></i></a>
                                                @endif
                                                @endif
                                            </li>
                                        </ul>

                                            </div>
                                        </div>
                                        <div class="row service_bar">
                                            
                                            <div class="col-sm-7">

                                                <ul class="list-inline">
                                                    @if($service->user)
                                                    <li class="list-inline-item">
                                                        <img src="{{ url($service->user->userdetail->first()->avater  ?? 'images/19571f92333dd5fba2598f637b68739c.png')}}" class="rounded-circle img-thumbnail img-fluid">
                                                        {{ $service->user->first_name.' '.$service->user->last_name }}
                                                    </li>
                                                    @endif
                                                    <li class="list-inline-item">
                                                        <span class="bg-light">{{$service->section->title[App::getLocale()]}}</span>
                                                    </li>
                                                </ul>

                                            </div>
                                            <div class="col-sm-5 pt-2">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <a class="btn btn-secondary rounded" href="#">{{ $service->cost}} {{trans('file.sr')}}</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="btn btn-primary rounded" href="{{url('/services/'.$service->title)}}">{{__('file.service_details')}}</a>
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

                    </div>
                </div>
                <!-- sidebar End -->

            </div>
        </div>
    </div>
@endsection



@section('jquery')
<script type="text/javascript">
    $(".updateFav").click(function() {

        var id = $(this).data("id");

        var data = {'id' : $(this).data("id")};

        $.ajax({    
            type  : 'get',
            url   : '{!!URL::route('updateFavorite')!!}',
            data  : data ,      
            success:function(data){

                console.log(data.result);

                if (data.result == 'done') {
                    $('.updateFav'+ id +' .fa').addClass('starred');
                }else {
                    $('.updateFav'+ id +' .fa').removeClass('starred');
                }
            },
        error:function(data){
            console.log(data.err)
        }
      });
    });   


</script>

@endsection