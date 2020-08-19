@extends('layouts.admin')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{{trans('admin.users')}}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.users')}}</li>
        </ol>
    </div>
    <div class="col-md-7 align-self-center">
        <a href="{{ url('/admin/departments/add') }}" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down"> {{trans('admin.adduser')}}</a>
    </div>
</div>
<div class="row">
    <!-- column -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans('admin.adduser')}}</h4>



                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        


                        {{ Form::open(['action' => 'UserController@store', 'files'=>true,'novalidate'=>'novalidate']) }}
                                <div class="form-group">
                                    <strong>Username:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Full Name:</strong>
                                    {!! Form::text('fullname', null, array('placeholder' => 'Full Name','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                </div>


                                <div class="form-group">
                                    <strong>Mobile:</strong>
                                    {!! Form::text('mobile', null, array('placeholder' => 'mobile','class' => 'form-control')) !!}
                                </div>


                                <div class="form-group">
                                    <strong>ID number:</strong>
                                    {!! Form::text('id_number', null, array('placeholder' => 'id_number','class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    <strong>Birthday:</strong>
                                    {!! Form::text('brith_day', null, array('placeholder' => 'brith_day','class' => 'form-control')) !!}
                                </div>

                                <div class="form-group {{  $errors->has('bio') ? 'has-error' : ''}}">
                                    {!! Form::label('bio', trans('admin.bio')) !!}
                                    {!! Form::textarea('bio', null, 
                                        array('required', 
                                              'class'=>'textarea form-control', 
                                              'id'=>'editor', 
                                              'placeholder'=>trans('admin.bio'))) !!}
                                </div>

                                <div class="form-group">
                                    <strong>Password:</strong>
                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                </div>


                                <div class="form-group">
                                    {!! Form::label('sex', trans('admin.status')) !!}
                                    {!!Form::select('sex', ['m' => trans('admin.male'), 'f' => trans('admin.female')], 'm', ['required', 'class' => 'form-control']) !!}
                                </div>


                                <div class="form-group">
                                    {!! Form::label('is_active', trans('admin.status')) !!}
                                    {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], '1', ['required', 'class' => 'form-control']) !!}
                                </div>




                                <div class="form-group">
                                    {!! Form::label('avatar', trans('admin.avatar')) !!}
                                    {!! Form::file('avatar', array( 'class' => 'form-control')) !!}
                                </div>


                                <div class="form-group">
                                    <strong>Role:</strong>
                                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                        {!! Form::close() !!}




            </div>
        </div>
    </div>
</div>
@endsection

@section('jquery')

@endsection