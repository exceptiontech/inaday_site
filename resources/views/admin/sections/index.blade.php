@extends('layouts.admin')

@section('title', 'home')

@section('content')

<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">{{trans('admin.sections')}}</h3>
        </div>

        <div class="box-body">

            @if (Session::has('message'))
              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                    <h4>{{Session::get('message')}}</h4>
              </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('admin.title')}}</th>
                            <th scope="col">{{trans('admin.slug')}}</th>
                            <th scope="col" width="400">{{trans('admin.desc')}}</th>
                            <th scope="col">{{trans('admin.status')}}</th>
                            <th scope="col">{{trans('admin.actions')}}</th>
                        </tr>
                    </thead>


                    @if(count($sections))

                    @foreach($sections as $section)
                    <tr>
                        <td>{{$section->id}}</td>
                        <td>{{@$section->title[App::getLocale()] }}</td>
                        <td>{{$section->slug}}</td>
                        <td>{{$section->desc[App::getLocale()]}}</td>
                        <td>
                          @if($section->is_active == 1)
                            <div class="label bg-green">
                              {{trans('admin.is_active')}}
                            </div>
                          @else 
                            <div class="label bg-red">
                              {{trans('admin.not_active')}}
                            </div>
                          @endif
                        </td>
                        <td class="actions" width="100">
                            <a class="btn btn-info" href="{{ action('Admin\SectionController@edit',$section->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                              <i class="fa fa-edit" aria-hidden="true"></i>
                            </a>
                            {{ Form::open(array('url' => 'admin/sections/' . $section->id, 'class' => 'pull-right')) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {!! Form::button('<i class="fa fa-remove" aria-hidden="true"></i>', array('class' => 'btn btn-danger','data-toggle'=>'tooltip','type'=>'submit', 'title'=>trans('admin.delete'))) !!}
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
                @if(count($sections))
              	{{ $sections->links() }}
              	@endif
            </div>
        </div>

    </div>
</div>

@endsection


@section('jquery')

@endsection