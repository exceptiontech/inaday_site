@extends('layouts.admin')

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
        <li>{{$title}}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row">

    <!-- column -->
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
            <h4>{{$title}}</h4>
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
                        <tr class="text-center">
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
                    <tr class="text-center">
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
                    @else
                    <tr>
                    	<td colspan="6">{{trans('admin.no_items')}}</td>
                    </tr>
                    @endif
                  </table>
                </div>
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