@extends('layouts.admin')

@section('content')
<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="box box-warning">
        <div class="box-header with-border mb-3">
            <h3 class="box-title">
              {{trans('admin.departments')}}
              @can('department-create')
              <span class="float-right">
                <a class="btn btn-primary" href="{{ url('/admin/departments/create?type=sponsors') }}">{{trans('admin.adddepartment')}}</a>
              </span>
              @endcan
            </h3>

        </div>

        <div class="box-body">

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
                                <th scope="col">{{trans('admin.image')}}</th>
                                <th scope="col">{{trans('admin.title')}}</th>
                                <th scope="col">{{trans('admin.desc')}}</th>
                                <th scope="col">{{trans('admin.parent')}}</th>
                                <th scope="col">{{trans('admin.status')}}</th>
                                <th scope="col">{{trans('admin.actions')}}</th>
                            </tr>
                        </thead>


                        @if(count($departments))

                        @foreach($departments as $department)
                        <tr>
                            <td>
                                @if($department->image)
                                    <img class="rounded-circle m-0 avatar-md" src="{{ asset($department->image) }}" alt="">
                                @else
                                    <img class="rounded-circle m-0 avatar-md" src="{{ asset('/images/not-found.png') }}" alt="">
                                @endif

                            </td>
                            <td>{{$department->title[App::getLocale()] }}</td>
                            <td>{{$department->desc[App::getLocale()] }}</td>

                            <td>
                                @if($department->parent)
                                    {{$department->parent->title}}
                                @else
                                    {{trans('admin.main_department')}}
                                @endif

                            </td>
                            <td>
                                  @if($department->is_active == 1)
                                    <div class="badge bg-green">
                                      {{trans('admin.is_active')}}
                                    </div>
                                  @else
                                    <div class="badge bg-red">
                                      {{trans('admin.not_active')}}
                                    </div>
                                  @endif

                            </td>

                            <td class="actions" width="120">
                                @can('department-edit')
                                    <a class="text-success mr-2" href="{{ action('Admin\DepartmentController@edit',$department->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                                      <i class="nav-icon i-Pen-2 font-weight-bold" aria-hidden="true"></i>
                                    </a>
                                @endcan
                                @can('department-delete')
                                    <a class="text-danger mr-2" href="#" onclick="event.preventDefault();
                                               document.getElementById('department{{$department->id}}').submit();" data-toggle="tooltip" title="{{trans('admin.delete')}}">
                                      <i class="nav-icon i-Close-Window font-weight-bold" aria-hidden="true"></i>
                                    </a>
                                @endcan
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


@section('jquery')

@endsection
