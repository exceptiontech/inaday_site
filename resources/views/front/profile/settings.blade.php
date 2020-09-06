@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{__('profile.settings')}}</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  profile rounded">
                        <div class="row">
                            <div class="col-12  profile-head-menu mb-5">

                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())
                                    <ul class="list-inline ">
                                        <li class="list-inline-item"><a class="active" href="#">خدماتي</a></li>
                                        <li class="list-inline-item"><a href="#">خلطاتي</a></li>
                                        <li class="list-inline-item"><a href="#">فريقي</a></li>
                                        <li class="list-inline-item"><a href="#">الفرق المشارك بها</a></li>
                                        <li class="list-inline-item"><a  href="#">الطلبات</a></li>
                                        <li class="list-inline-item"><a href="#">محفظتي</a></li>
                                    </ul>
                                @elseif(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive())
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/profile/edit')}}">نبذة عني</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/projects')}}">مشاريعي</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/bookings')}}">الحجوزات</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/notifications')}}">الاشعارات</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/')}}">الاعدادات</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>

                            <div class="col-12 profile-content mb-5">

                              @if ($errors->any())
                                  <div class="alert alert-danger">
                                      <ul>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @endif

                              {{ Form::open(['action' => 'UsersController@update', 'files'=>true,'novalidate'=>'novalidate']) }}

                                <h2 class="dark mb-4">{{__('profile.settings')}}</h2>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('blog', 'الاشتراك في المدونة')!!}
                                        {!! Form::file('avater', array( 'class' => 'form-control')) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('first_name', trans('profile.first_name'))!!}
                                        {!! Form::text('first_name', Auth::user()->first_name, ['required','class' => 'form-control']) !!}

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        {!! Form::label('notes', trans('profile.notes'))!!}
                                        {!! Form::textarea('notes', Auth::user()->userdetail->first()->notes ?? '', array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'notes','placeholder'=>'يمكنك كتابة نبذة مختصرة عنك لتدعم قوة ظهور الملف الشخصى لدى رواد الأعمال وأصحاب المشاريع')) !!}

                                    </div>
                                </div>

                                @if(Auth::user()->isServicesProvider())
                                <h2 class="dark mt-5 mb-4">{{__('profile.job_information')}}</h2>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('jobtype_id', trans('profile.jobtype'))!!}
                                        {!! Form::select('jobtype_id',$jobtypes->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->jobtype_id ?? '' ,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('prefer_id', trans('profile.prefer'))!!}
                                        {!! Form::select('prefer_id',$prefers->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->prefer_id ?? '',['required', 'class' => 'form-control']) !!} 

                                    </div>
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('costkind_id', trans('profile.costkind'))!!}
                                        {!! Form::select('costkind_id',$costkinds->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->costkind_id ?? '' ,['required', 'class' => 'form-control']) !!} 

                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('level_id', trans('profile.levels'))!!}
                                        {!! Form::select('level_id',$levels->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->level_id ?? '',['required', 'class' => 'form-control']) !!} 

                                    </div>

                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('skills[]', trans('profile.skills'))!!}
                                        {!! Form::select('skills[]',$skills->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->skill_id ?? '',['required', 'class' => 'form-control']) !!} 
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('skills[]', trans('profile.anthor_skill'))!!}
                                        {!! Form::text('skills[]', null, ['required','class' => 'form-control']) !!}

                                    </div>
                                </div>
                                @endif

                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('profile.update'), array('class'=>'btn btn-primary')) !!}

                                    </div>
                                </div>
                            {{ Form::close() }}


                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>



@endsection

@section('jquery')
  <script type="text/javascript">

    $("#country_id").change(function() {

    $('#city_id').empty();

      var data = {'country_id' : $( "#country_id option:selected" ).val()};

      $.ajax({    
        type  : 'get',
        url   : '{!!URL::route('getCities')!!}',
        data  : data ,      
        success:function(data){

        if (data.length > 0) {
            html = "";

            for (i = 0; i < data.length; i++) { 
                html += '<option value="'+data[i].id+'">'+data[i].title.ar+'</option>'; 
            } 
            $('#city_id').removeAttr('disabled','disabled');
            $('#city_id').html(html);
        }else {
            $('#city_id').attr('disabled','disabled');
        }

        },
        error:function(data){
          console.log(data.err)
        }
      });
    }); 
    
    var monthNames = [ "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December" ];

    for (i = new Date().getFullYear(); i > 1900; i--){
        $('#years').append($('<option />').val(i).html(i));
    }
        
    for (i = 1; i < 13; i++){
        $('#months').append($('<option />').val(i).html(i));
    }
     updateNumberOfDays(); 
        
    $('#years, #months').on("change", function(){
        updateNumberOfDays(); 
    });



    function updateNumberOfDays(){
        $('#days').html('');
        month=$('#months').val();
        year=$('#years').val();
        days=daysInMonth(month, year);

        for(i=1; i < days+1 ; i++){
                $('#days').append($('<option />').val(i).html(i));
        }
    }

    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    $('#readiness_date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true

    });


  </script>
@endsection

