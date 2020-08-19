@extends('layouts.admin')

@section('title', 'home')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{{trans('admin.roles')}}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.roles')}}</li>
        </ol>
    </div>
    <div class="col-md-7 align-self-center">
        @can('role-create')
        <a href="{{ route('roles.index') }}" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down"> {{trans('admin.roles')}}</a>
        @endcan
    </div>
</div>
<div class="row">
    <!-- column -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans('admin.roles')}}</h4>






<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permissions:</strong>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label class="label label-success">{{ $v->name }},</label>
                @endforeach
            @endif
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

@endsection