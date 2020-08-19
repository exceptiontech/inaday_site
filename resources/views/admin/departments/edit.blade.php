@extends('layouts.admin')


@section('before-css')


@endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/quill.bubble.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/quill.snow.css')}}">
@endsection

@section('content')

<div class="breadcrumb">
    <h1>{{trans('admin.departments')}}</h1>
    <ul>
        <li><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
        <li>{{trans('admin.departments')}}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <!-- column -->
    <div class="col-md-12">
        <h4>{{trans('admin.editdepartment')}}</h4>
        <p></p>
        <div class="card mb-5">
            <div class="card-body">

                {{ Form::model($department, array('route' => array('departments.update', $department->id), 'method' => 'PUT', 'files'=>true)) }}

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="form-group {{  $errors->has('title') ? 'has-error' : ''}}">

                        {!! Form::hidden('locale', App::getLocale(), ['required','class' => 'form-control','autocomplete'=>'off','id'=>'locale']) !!}

                        {!! Form::label('title', trans('admin.name'))!!}
                        {!! Form::text('title', $department->title, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title']) !!}
                    </div>


                    <div class="form-group {{  $errors->has('desc') ? 'has-error' : ''}}">
                        {!! Form::label('desc', trans('admin.desc')) !!}
                        {!! Form::textarea('desc', $department->desc, 
                            array('required', 
                                  'class'=>'textarea form-control', 
                                  'id'=>'editor', 
                                  'placeholder'=>trans('admin.desc'))) !!}
                    </div>


                    @if(count($departments) > 0)
                    <div class="form-group">
                        {!! Form::label('parent_id', trans('admin.parents'))  !!}

                        {!! Form::select('parent_id',$departments->pluck('title','id'), $department->parent_id ,[ 'class' => 'form-control','placeholder'=>'قسم اب']) !!} 
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('image', trans('admin.image')) !!}
                        @if($department->image)
                        <div class="row">
                            <div class="col-11">
                                {!! Form::file('image', array( 'class' => 'form-control')) !!}
                            </div>
                            <div class="col-1 text-center">
                                <img class="rounded-circle m-0 avatar-md" src="{{ asset($department->image) }}" alt="">
                            </div>
                        </div>
                        @else
                            {!! Form::file('image', array( 'class' => 'form-control')) !!}
                        @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('is_active', trans('admin.status')) !!}
                        {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $department->is_active, ['required', 'class' => 'form-control']) !!}
                    </div>

                        {!! Form::submit(trans('admin.save'), 
                          array('class'=>'btn btn-primary')) !!}

                
                {{ Form::close() }}
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('page-js')

    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="{{asset('assets/dashboard/js/scripts/vendor/quill.min.js')}}"></script>

@endsection

@section('bottom-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="{{asset('assets/dashboard/js/scripts/plugins/quill.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/scripts/customizer.script.min.js')}}"></script>

    <script src="{{asset('assets/dashboard/js/scripts/quill.script.js')}}"></script>
@endsection