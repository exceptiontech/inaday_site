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
    <div class="col-md-7 align-self-center text-right ">
        <a href="{{ url('/admin/users') }}" class="btn waves-effect waves-light btn btn-info hidden-sm-down"> {{trans('admin.users')}}</a>
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

                        


                        {{ Form::open(['action' => 'Admin\UserController@store', 'files'=>true,'novalidate'=>'novalidate']) }}
                                <div class="form-group">
                                    <strong>{{trans('admin.username')}}</strong>
                                    {!! Form::text('name', null, array('placeholder' => trans('admin.username'),'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>{{ trans('admin.first_name') }}</strong>
                                    {!! Form::text('first_name', null, array('placeholder' => trans('admin.first_name'),'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>{{ trans('admin.last_name') }}</strong>
                                    {!! Form::text('first_name', null, array('placeholder' => trans('admin.last_name'),'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>{{trans('admin.email')}}</strong>
                                    {!! Form::text('email', null, array('placeholder' => trans('admin.email'),'class' => 'form-control')) !!}
                                </div>


                                <div class="form-group">
                                    <strong>{{trans('admin.mobile')}}</strong>
                                    {!! Form::text('mobile', null, array('placeholder' => trans('admin.mobile'),'class' => 'form-control')) !!}
                                </div>




                                <div class="form-group">
                                    <strong>{{trans('admin.password')}}</strong>
                                    {!! Form::password('password', array('placeholder' => trans('admin.password'),'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>{{trans('admin.confirm_password')}}</strong>
                                    {!! Form::password('confirm-password', array('placeholder' => trans('admin.confirm_password'),'class' => 'form-control')) !!}
                                </div>


                                <div class="form-group">
                                    {!! Form::label('is_active', trans('admin.status')) !!}
                                    {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], '1', ['required', 'class' => 'form-control']) !!}
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