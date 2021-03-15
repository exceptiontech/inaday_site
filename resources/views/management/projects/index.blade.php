@extends('layouts.admin')

@section('content')



<div class="breadcrumb">
    <h1>{{trans('admin.projects')}}</h1>
    <ul>
        <li><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
        <li>{{trans('admin.projects')}}</li>
    </ul>
    @can('project-create')
      <span class="mr-auto">
        <a class="btn btn-primary" href="{{ url('/admin/projects/create') }}">{{trans('admin.addproject')}}</a>
      </span>
    @endcan

</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row">

    <!-- column -->
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
            <h4>{{trans('admin.projects')}}</h4>
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
                            <th scope="col">{{trans('admin.owner')}}</th>
                            <th scope="col">{{trans('admin.approved')}}</th>
                            <th scope="col">{{trans('admin.date')}}</th>
                            <th scope="col">{{trans('admin.actions')}}</th>
                        </tr>
                    </thead>



                    <tbody>
                        @if(count($projects))
                            @foreach($projects as $project)
                            <tr>
                                <td>{{$project->id}}</td>
                                <td>{{@$project->title }}</td>
                                <td>{!! \Illuminate\Support\Str::words($project->desc,350,'....')  !!}</td>
                                <td>
                                    @if($project->user)
                                    {{$project->user->first_name.' '  .$project->user->last_name }}
                                    @else
                                        المستخدم محذوف
                                    @endif
                                </td>
                                <td> 
                                    @if($project->is_approved == 1)
                                        <a href="#" class="badge badge-success">{{trans('admin.yes')}}</a>
                                    @else
                                        <a href="#" class="badge badge-danger">{{trans('admin.no')}}</a>
                                    @endif
                                </td>
                                <td>{{$project->created_at }}</td>

                                <td class="actions" width="200">

                                  <a class="btn btn-secondary" href="{{ action('ProjectController@show',$project->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                                    {{trans('admin.show')}}
                                  </a>

                                  <a class="btn btn-primary" href="{{ action('Admin\ProjectController@approve',$project->id) }}" data-toggle="tooltip" title="{{trans('admin.approve')}}">
                                    {{trans('admin.approve')}}
                                  </a>

                                  <a class="btn btn-danger" data-toggle="modal" data-target="#item{{$project->id}}">
                                    {{trans('admin.refuse')}}
                                  </a>

                                    <div class="modal fade" id="item{{$project->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        {{ Form::open(['action' => 'Admin\ProjectController@refuse']) }}
                                        <div class="modal-content">

                                          <div class="modal-body">

                                            {!! Form::hidden('model_id', $project->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                                            <label>{{trans('admin.refuse_reason')}}</label>
                                            {!! Form::textarea('desc', null,  array('required', 'class'=>'textarea form-control', 'rows'=>'4')) !!}

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('admin.close')}}</button>

                                            {!! Form::submit(trans('admin.add'), array('class'=>'btn btn-primary ml-2')) !!}
                                          </div>
                                        </div>

                                        {{ Form::close() }}
                                      </div>
                                    </div>                                  

                                  <!-- <a class="btn btn-danger" href="{{ action('Admin\ProjectController@refuse',$project->id) }}" data-toggle="tooltip" title="{{trans('admin.refuse')}}">
                                    {{trans('admin.refuse')}}
                                  </a> -->



                                  <!-- <a class="btn btn-info" href="{{ action('Admin\ProjectController@edit',$project->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                                    {{trans('admin.edit')}}
                                  </a>
                                  {{ Form::open(array('url' => 'admin/projects/' . $project->id,'style'=>'display:inline')) }}
                                      {{ Form::hidden('_method', 'DELETE') }}
                                      {!! Form::button(trans('admin.delete'), array('class' => 'btn btn-danger','data-toggle'=>'tooltip','type'=>'submit', 'title'=>trans('admin.delete'))) !!}
                                  {{ Form::close() }} -->


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