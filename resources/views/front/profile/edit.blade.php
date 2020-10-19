@extends('layouts.inner')
@section('title')
  تعديل البيانات
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">تعديل البيانات</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  profile rounded">
                        <div class="row">
                            <div class="col-12  profile-head-menu mb-5">

                            @include('front.profile.parts.edit')

                            </div>

                            <div class="col-12 profile-content mb-5">

                            @if (Session::has('message'))
                              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                    {{Session::get('message')}}
                              </div>
                            @endif

                              {{ Form::open(['action' => 'UsersController@update', 'files'=>true,'novalidate'=>'novalidate']) }}


                            @if(count($errors) > 0)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissable" >
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{ $error}}
                                    </div>
                                @endforeach
                            @endif

                                <h2 class="dark mb-4">{{__('profile.personal_information')}}</h2>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('avater', trans('profile.avater'))!!}
                                        <div class="d-flex d-inline-flex">
                                            <a class="text-danger" href="{{url('/account/profile/removeAvater')}}"><i class="fa fa-trash"></i></a>
                                            <img class=" rounded-circle img-icon50 mr-1" src="{{ url(Auth::user()->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}">
                                            
                                            {!! Form::file('avater', array( 'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('first_name', trans('profile.first_name'))!!}<em class="text-danger">*</em>
                                        {!! Form::text('first_name', Auth::user()->first_name, ['required','class' => 'form-control']) !!}

                                    </div>
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('last_name', trans('profile.last_name'))!!}<em class="text-danger">*</em>
                                        {!! Form::text('last_name', Auth::user()->last_name, ['required','class' => 'form-control']) !!}

                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('mobile', trans('profile.mobile'))!!}<em class="text-danger">*</em>
                                        {!! Form::text('mobile', Auth::user()->mobile, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('email', trans('profile.email'))!!}
                                        {!! Form::email('email', Auth::user()->email, ['required','class' => 'form-control','disabled'=>'disabled']) !!}

                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('password', trans('profile.password'))!!}
                                        {{ Form::password('password', array('id' => 'password', "class" => "form-control")) }}

                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('password_confirmation', trans('forms.co_password'))!!}
                                        {{ Form::password('password_confirmation', array('id' => 'password', "class" => "form-control")) }}

                                    </div>


                                </div>


                                <h2 class="dark mt-5 mb-4">البيانات الوظيفية</h2>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('position', trans('profile.position'))!!}<em class="text-danger">*</em>
                                        {!! Form::text('position', Auth::user()->userdetail->first()->position ?? '', ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('country_id', trans('profile.country'))!!}<em class="text-danger">*</em>
                                        {!! Form::select('country_id',$countries->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->country_id ?? '',['required', 'class' => 'form-control','placeholder'=>'اختر']) !!} 

                                    </div>
                                    <div class="col-12 col-sm-4">
                                        {!! Form::label('city_id', trans('profile.city'))!!}<em class="text-danger">*</em>
                                        {!! Form::select('city_id',$cities->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->city_id ?? '',['required', 'class' => 'form-control','placeholder'=>'اختر']) !!} 

                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <div class="col-12">
                                        {!! Form::label('cv_file', trans('profile.cv_file'))!!}
                                        @if(count(Auth::user()->userdetail) && Auth::user()->userdetails->first()->cv_file)
                                          <div class="d-flex d-inline-flex w-100">
                                                <a class="text-danger"  href="{{url('/account/profile/removeCV')}}"><i class="fa fa-trash"></i></a>
                                              <a download="download" href="{{ url(Auth::user()->userdetail->first()->cv_file) }}">
                                               <i class="fa fa-file-o fa-3x mr-4" aria-hidden="true"></i>
                                              </a>
                                              {!! Form::file('cv_file', array( 'class' => 'form-control')) !!}
                                          </div>
                                        @else
                                            {!! Form::file('cv_file', array( 'class' => 'form-control')) !!}
                                        @endif

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        {!! Form::label('notes', trans('profile.notes'))!!}
                                        {!! Form::textarea('notes', Auth::user()->userdetail->first()->notes ?? '', array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'notes','placeholder'=>'يمكنك كتابة نبذة مختصرة عنك لتدعم مستوى الملف الشخصى لدى رواد الأعمال وأصحاب المشاريع')) !!}

                                    </div>
                                </div>

                                @if(Auth::user()->isServicesProvider())
                                <h2 class="dark mt-5 mb-4">{{__('profile.job_information')}}</h2>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('jobtype_id', trans('profile.jobtype'))!!}
                                        {!! Form::select('jobtype_id',$jobtypes->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->jobtype_id ?? '' ,['required', 'class' => 'form-control','placeholder'=>'اختر']) !!} 
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('prefer_id', trans('profile.prefer'))!!}
                                        {!! Form::select('prefer_id',$prefers->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->prefer_id ?? '',['required', 'class' => 'form-control','placeholder'=>'اختر']) !!} 

                                    </div>
                                    <!-- <div class="col-12 col-sm-4">
                                        {!! Form::label('costkind_id', trans('profile.costkind'))!!}<em class="text-danger">*</em>
                                        {!! Form::select('costkind_id',$costkinds->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->costkind_id ?? '' ,['required', 'class' => 'form-control']) !!} 

                                    </div> -->
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('level_id', trans('profile.levels'))!!}
                                        {!! Form::select('level_id',$levels->pluck('title.'.App::getLocale(),'id'), Auth::user()->userdetail->first()->level_id ?? '',['required', 'class' => 'form-control','placeholder'=>'اختر']) !!} 

                                    </div>

                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('skills[]', trans('profile.skills'))!!}<em class="text-danger">*</em>
                                        {!! Form::select('skills[]',$skills->pluck('title.'.App::getLocale(),'id'), Auth::user()->DefaultSkill()->id ?? '',['required', 'class' => 'form-control','placeholder'=>'اختر']) !!} 
                                    </div>
                                    <!-- <div class="col-12 col-sm-4">
                                        {!! Form::label('skills[]', trans('profile.anthor_skill'))!!}
                                        {!! Form::text('skills[]', null, ['required','class' => 'form-control']) !!}

                                    </div> -->
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


    $(document).ready(function(){

    // $('#city_id').empty();

    //   var data = {'country_id' : 1};

    //   $.ajax({    
    //     type  : 'get',
    //     url   : '{!!URL::route('getCities')!!}',
    //     data  : data ,      
    //     success:function(data){

    //     if (data.length > 0) {
    //         html = "";

    //         for (i = 0; i < data.length; i++) { 
    //             html += '<option value="'+data[i].id+'">'+data[i].title.ar+'</option>'; 
    //         } 
    //         $('#city_id').removeAttr('disabled','disabled');
    //         $('#city_id').html(html);
    //     }else {
    //         $('#city_id').attr('disabled','disabled');
    //     }

    //     },
    //     error:function(data){
    //       console.log(data.err)
    //     }
    //   });
    // }); 


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

