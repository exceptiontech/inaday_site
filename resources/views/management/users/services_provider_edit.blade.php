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
                          <div class="col-sm-6 inpudata">
                            <label> {{ __('forms.image') }}<em>*</em></label>
                            <div class="input-group">
                              <label class="input-group-btn"><span class="btn btn-primary" >{{ __('forms.image') }}
                                  <input type="file" name="avater"  style="display: none;" ></span></label>
                              <input class="form-control" type="text"  readonly>
                            </div>
                        </div>
                        <div class="col-sm-12 inpusrach">
                            <div class="clearfix">&nbsp; </div>
                            <h3 class="title">البيانات الفرعيه</h3>
                            <div class="clearfix">&nbsp; </div>
                        </div>
                        <div class="col-sm-6 inpudata">
                            <div class="select">
                              <label>كيف تبغى تكون مقدم خدمة؟ <em>*</em></label>

                              {!! Form::select('jobtype_id',$jobtypes->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->jobtype_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}

                            </div>
                          </div>
                          <div class="col-sm-6 inpudata">
                            <div class="select">
                              <label>حاجتك للتدريب<em>*</em></label>

                              {!! Form::select('level_id',$levels->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->level_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}

                            </div>
                          </div>
                          <div class="col-sm-6 inpudata">

                            <div class="select">
                              <label>فردي أم فريق<em>*</em></label>

                              {!! Form::select('prefer_id',$prefers->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->prefer_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}

                            </div>
                          </div>
                          <div class="col-sm-3 inpudata">
                            <div class="select">
                              <label>التكلفة<em>*</em></label>

                              {!! Form::select('costkind_id',$costkinds->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->costkind_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}

                            </div>
                          </div>
                          <div class="col-sm-3 inpudata">
                            <div class="select">
                              <label>التقديم<em>*</em></label>

                              {!! Form::select('applykind_id',$applykinds->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->applykind_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}

                            </div>
                          </div>

                          <div class="col-sm-6 inpudata"><label class="mb-0">كم متوسط تكلفة الخدمة ؟</label>
                            <div class="select texright">
                                <button class="text-mo btn btn-default col-sm-3">اساسى</button>

                              {!! Form::select('averagekind_id',$averagekinds->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->averagekind_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}

                            </div>
                          </div>
                          <div class="col-sm-6 inpudata">
                            <div class="select mony"><span class="text-mo">ريال</span>
                                <input name="average_cost" class="form-control" type="number" min="0" value="{{ $user->userdetail->first()->average_cost }}" placeholder="">
                            </div>
                          </div>
                          <div class="col-sm-6 inpudata marg">
                            <div class="select">
                                <label class="mb-2">في حال وجود مكافأة أفضل حصولي عليها</label>

                              {!! Form::select('rewardkind_id',$rewardkinds->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->rewardkind_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}
                            </div>
                          </div>
                          <div class="col-sm-6 inpudata">
                            <label> تاريخ الميلاد<em>*</em></label>
                            <div class="row">
                            <div class="col-4"><select class="form-control" name="day" id="days"></select></div>
                            <div class="col-4"><select class="form-control" name="month" id="months"></select></div>
                            <div class="col-4"><select class="form-control" name="year" id="years"></select></div>
                            </div>

                        </div>
                        <div class="col-sm-6 inpudata">

                            <div class="select">
                            <label> مكان الاقامة<em>*</em></label>

                              {!! Form::select('country_id',$countries->pluck('title.'.App::getLocale(),'id'), $user->userdetail->first()->country_id, ['required', 'class' => 'form-control','placeholder'=> trans('file.choose')]) !!}


                            </div>
                        </div>
                        <div class="col-sm-6 inpudata">
                            <label> المهنة<em>*</em></label>
                            <div class="select">
                              <input name="position" class="form-control" type="text" value="{{ $user->userdetail->first()->position }}" placeholder="" required>
                            </div>
                          </div>
                          <div class="col-sm-6 inpudata">
                            <label> تحميل السيرة الذاتية<em>*</em></label>
                            <div class="input-group">
                              <label class="input-group-btn"><span class="btn btn-primary">تصفح
                                  <input type="file" name="cv_file"  style="display: none;" ></span></label>
                              <input class="form-control" type="text" readonly>
                            </div>
                          </div>
                        <div class="col-sm-12 inpudata">
                            <label> ملاحظات</label>
                            <textarea class="form-control" name="notes" rows="5" placeholder=" حلمك من خلال عملك في منصة .انادي."> {{ $user->userdetail->first()->notes }}</textarea>
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
