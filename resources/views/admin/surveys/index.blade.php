@extends('layouts.admin')

@section('content')


<div class="breadcrumb">
    <h1>{{trans('admin.surveys')}}</h1>
    <ul>
        <li><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
        <li>{{trans('admin.surveys')}}</li>
    </ul>
    @can('survey-create')
      <span class="mr-auto">
        <a class="btn btn-primary" href="{{ url('/admin/surveys/create') }}">{{trans('admin.addsurvey')}}</a>
      </span>
    @endcan

</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row">

    <!-- column -->
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
            <h4>{{trans('admin.surveys')}}</h4>
            <p></p>


            @if (Session::has('message'))
            <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                {{Session::get('message')}}
            </div>
            @endif

            <div class="table-responsive">
                <table id="scroll_horizontal_table" class="display table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('admin.title')}}</th>
                            <th scope="col">{{trans('admin.desc')}}</th>
                            <th scope="col">{{trans('admin.start_date')}}</th>
                            <th scope="col">{{trans('admin.end_date')}}</th>
                            <th scope="col">{{trans('admin.role')}}</th>
                            <th scope="col">{{trans('admin.actions')}}</th>
                        </tr>
                    </thead>



                    <tbody>
                        @if(count($surveys))
                            @foreach($surveys as $survey)
                            <tr>
                                <td>{{$survey->id}}</td>
                                <td>{{@$survey->title }}</td>
                                <td>{!! \Illuminate\Support\Str::words($survey->desc,350,'....')  !!}</td>
                                <td>{{@$survey->start_date }}</td>
                                <td>{{ $survey->end_date }}</td>
                                <td>{{ @$survey->role->name }}</td>

                                <td class="actions" width="200">

                                  <a class="btn btn-info" href="{{ action('Admin\SurveyController@edit',$survey->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                                    {{trans('admin.edit')}}
                                  </a>
                                  {{ Form::open(array('url' => 'admin/surveys/' . $survey->id,'style'=>'display:inline')) }}
                                      {{ Form::hidden('_method', 'DELETE') }}
                                      {!! Form::button(trans('admin.delete'), array('class' => 'btn btn-danger','data-toggle'=>'tooltip','type'=>'submit', 'title'=>trans('admin.delete'))) !!}
                                  {{ Form::close() }}


                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">
                                    {{trans('admin.no_items')}}
                                </td>
                            </tr>

                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection

@section('page-js')
    <script src="{{asset('assets/dashboard/js/scripts/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/scripts/datatables.script.js')}}"></script>s
@endsection

@section('jquery')

@endsection