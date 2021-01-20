@extends('layouts.inner')

@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{trans('file.themixtures')}}</h2>
                </div>
                <!-- sidebar Begin -->
                <div class="col-12 col-md-4">
                    <div class="bg-light rounded pt-3 pb-3 p-2">

                        {{ Form::open(['action' => 'MixtureController@index','method' => 'get']) }}


                        <!-- block Begin -->
                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <div class="col-12">
                                    <h2>{{trans('file.by_skill')}} </h2>
                                </div>
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
                                <div class="col-12">
                                    <h2>{{trans('file.by_section')}} </h2>
                                </div>
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
                                <div class="col-12">
                                    <h2>{{trans('file.by_title')}}</h2>
                                </div>
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


                            <!-- mixtures -->
                        @if (count($mixtures))
                            @foreach ($mixtures as $mixture)
                            <div class="service col-12 pt-3 pb-2 mb-3">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <img class="img-fluid" src="{{ url($mixture->image ?? 'assets/images/logo.png') }}" alt="{{ $mixture->title }}" title="{{ $mixture->title }}">
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-10 mb-3">
                                                <h2><a href="{{url('/mixtures/'.$mixture->id)}}">{{$mixture->title}}</a></h2>
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
                                                        <a target="_blank" data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/share?url={{url('/mixtures/'.$mixture->title)}}&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" class="btn btn-twitter" >
                                                      <i class="fa fa-twitter"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a target="_blank"  href="http://www.facebook.com/sharer.php?u={{url('/mixtures/'.$mixture->title)}}" class="btn btn-facebook" >
                                                      <i class="fa fa-facebook"></i>
                                                    </a>
                                                    </li>         
                                                      <li>
                                                      <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{url('/mixtures/'.$mixture->title)}}" class="btn btn-linkedin" data-placement="left">
                                                      <i class="fa fa-linkedin"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a  class="btn btn-mail" href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{url('/mixtures/'.$mixture->title)}}">
                                                      <i class="fa fa-envelope"></i>
                                                    </a>
                                                    </li>
                                                  </ul>
                                                </div>
                                              </div>

                                            </li>

                                             <li class="list-inline-item">
                                                @if(Auth::user())
                                                @if(Auth::user()->MixturehasFavorite($mixture->id))
                                                    <a id="RemoveFromFav" class="updateFav updateFav{{$mixture->id}}" data-id="{{$mixture->id}}" data-type="mixture" href="#">
                                                    <i class="fa fa-star starred" aria-hidden="true"></i></a>
                                                @else
                                                    <a id="AddToFav" class="updateFav updateFav{{$mixture->id}}" data-id="{{$mixture->id}}" data-type="mixture"  href="#">
                                                    <i class="fa fa-star" aria-hidden="true"></i></a>
                                                @endif
                                                @endif
                                            </li>
                                        </ul> 

                                            </div>
                                        </div>
                                        <div class="row service_bar">
                                            
                                            <div class="col-sm-7">

                                                <ul class="list-inline">
                                                    @if($mixture->team)
                                                    <li class="list-inline-item">
                                                        <img src="{{ url($mixture->team->image  ?? 'assets/images/logo.png')}}" class="rounded-circle img-thumbnail img-fluid">
                                                        {{ $mixture->team->title ?? '' }}
                                                    </li>
                                                    @endif
                                                    @if(count($mixture->services) > 0)
                                                        <li class="list-inline-item">
                                                            <span class="bg-light">عدد الخدمات : {{ count($mixture->services) }}</span>
                                                        </li>
                                                    @else
                                                    <li class="list-inline-item">
                                                        <span class="bg-light">بدون خدمات</span>
                                                    </li>
                                                    @endif
                                                </ul>

                                            </div>
                                            <div class="col-sm-5 pt-2">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <label class="btn btn-secondary rounded text-white font-weight-light" href="#">{{ $mixture->cost}} {{trans('file.sr')}}</label>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="btn btn-primary rounded" href="{{url('/mixtures/'.$mixture->id)}}">{{__('file.mixture_details')}}</a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                             </div>

                            @endforeach
                            {{ $mixtures->appends(request()->input())->links() }}
                            @else
                                <div class="alert alert-danger">
                                    <i class="fa fa-exclamation-triangle"></i> {{trans('file.no_mixtures')}}
                                </div>
                          @endif
                            <!-- mixtures -->
                            

                            
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

        var data = {'id' : $(this).data("id"),'type' : $(this).data("type")};

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