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
    <div class="col-md-7 align-self-center text-right">
        <a href="{{ url('/admin/users') }}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down"> {{trans('admin.users')}}</a>
    </div>
</div>
<div class="row">
    <!-- column -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans('admin.edituser')}}</h4>


                {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT', 'files'=>true)) }}

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <div class="row">
                        <div class="col-sm-6 inpudata">
                          <label>الاسم الأول</label>
                          <input class="form-control" type="text" name="first_name" placeholder="" value="{{ $user->first_name ?? '' }}" >
                        </div>
                        <div class="col-sm-6 inpudata">
                          <label>الاسم الاخير</label>
                          <input class="form-control" type="text" name="last_name" placeholder="" value="{{ $user->last_name  ?? ''}}" >
                        </div>
                        <div class="col-sm-6 inpudata">
                          <label>البريد الإلكترونى</label>
                          <input class="form-control" type="email" name="email" placeholder="{{ $user->email  ?? '' }}" readonly>
                        </div>
                        <div class="col-sm-6 inpudata">
                          <label>رقم الهاتف</label>
                          <input class="form-control" type="number" name="mobile" placeholder="" value="{{ $user->mobile  ?? '' }}" >
                        </div>
                        <div class="col-sm-6 inpudata  {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label>{{ __('register_lang.password') }}<em>*</em></label>
                            <input  id="password"  name="password"  type="password"  class="form-control  {{ $errors->has('password') ? ' is-invalid' : '' }}" aria-required="true" placeholder="{{ __('register_lang.password') }}"
                            />
                            @if ($errors->has('password'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                          </div>
                          <div class="col-sm-12 inpudata">
                            <label> {{ __('forms.image') }}<em>*</em></label>
                            <div class="input-group">
                              <label class="input-group-btn"><span class="btn btn-primary" >{{ __('forms.image') }}
                                  <input type="file" name="avater"  style="display: none;" ></span></label>
                              <input class="form-control" type="text"  readonly>
                            </div>
                        </div>
                        <div class="col-sm-12 inpudata">

                          <div class="form-group">
                              {!! Form::label('is_active', trans('admin.status')) !!}
                              {!! Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $user->is_active, ['required', 'class' => 'form-control']) !!}
                          </div>
                        </div>

                        <div class="col-sm-12 inpudata">

                          {!! Form::submit(trans('admin.save'),
                          array('class'=>'btn btn-info')) !!}
                        </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

</div>
@endsection

@section('jquery')

<script type="text/javascript">


</script>
@endsection
