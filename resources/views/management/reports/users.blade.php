@extends('layouts.management')

@section('before-css')


@endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/datatables.min.css')}}">
@endsection

@section('content')

<div class="breadcrumb">
    <h1>{{trans('admin.users')}}</h1>
    <ul>
        <li><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
        <li>{{trans('admin.users')}}</li>
    </ul>

    @can('user-create')
      <span class="mr-auto">
        <a class="btn btn-primary" href="{{ url('/admin/users/create') }}">{{trans('admin.adduser')}}</a>
      </span>
    @endcan

</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row">

    <!-- column -->
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
            <h4>{{trans('admin.users')}}</h4>
            <p></p>


            @if (Session::has('message'))
              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                    {{Session::get('message')}}
              </div>
            @endif

            @can('reports-list')


            {{ Form::open(['action' => 'ManagementController@userReport','method' => 'get']) }}
                <div id="searchform" class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                          {!! Form::label('roles', trans('admin.roles'))!!}

                            {!!Form::select('role_id', $roles, Request::get('role_id'), ['id' => 'role_id','class' => 'form-control','placeholder'=>trans('admin.all')]) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          {!! Form::label('start_date', trans('admin.fromdate'))!!}
                            {!!Form::text('start_date', Request::get('start_date'), ['id' => 'fromdate','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          {!! Form::label('end_date', trans('admin.todate'))!!}
                            {!!Form::text('end_date', Request::get('end_date'), ['id' => 'todate','class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-sm-2">  
                        <div class="form-group">
                        <label for="title">&nbsp;</label>
                        {!! Form::button(trans('admin.search'), 
                                      array('class'=>'btn btn-block btn-success','id'=>'search-button', 'type'=>'submit')) !!}
                        </div>
                    </div>

                </div>
            {{ Form::close() }}



            <div id="results" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="">
                            <th scope="col">{{trans('admin.id')}}</th>
                            <th scope="col">{{trans('admin.title')}}</th>
                            <th scope="col">{{trans('admin.email')}}</th>
                            <th scope="col">{{trans('admin.mobile')}}</th>
                            <th scope="col">{{trans('admin.role')}}</th>
                            <th scope="col">{{trans('admin.created_at')}}</th>
                            <th scope="col">{{trans('admin.actions')}}</th>
                        </tr>
                    </thead>


                    @if(count($users))

                    @foreach($users as $user)
                    <tr class="">
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->mobile}}</td>
                        <td>{{$user->roles->first()->name}}</td>
                        <td>{{$user->created_at}}</td>

                        <td class="actions" width="120">
                            <a class="btn btn-info" href="{{ action('Admin\UserController@edit',$user->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                              {{trans('admin.edit')}}
                            </a>
                            {{ Form::open(array('url' => 'admin/users/' . $user->id,'style'=>'display:inline')) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {!! Form::button(trans('admin.delete'), array('class' => 'btn btn-danger','data-toggle'=>'tooltip','type'=>'submit', 'title'=>trans('admin.delete'))) !!}
                            {{ Form::close() }}
                        </td>


                    </tr>
                    @endforeach

                    <tr class="bg-info text-white font-weight-bolder">
                        <td colspan="5">
                            @lang('admin.total')
                        </td>
                        <td colspan="2">
                            {{count($users)}} 
                        </td>
                    </tr>



                    @else
                    <tr>
                    	<td colspan="6">{{trans('admin.no_items')}}</td>
                    </tr>
                    @endif
                  </table>
                  {{ $users->appends(request()->input())->links() }}

            </div>

            @else
                ليس لديك الصلاحيات
            @endcan

            </div>
        </div>
    </div>
</div>

@endsection


@section('page-js')
    <script src="{{asset('assets/dashboard/js/scripts/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/scripts/datatables.script.js')}}"></script>s
@endsection

@section('bottom-js')

@endsection