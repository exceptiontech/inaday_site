@extends('layouts.admin')

@section('content')

<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="box box-warning">
        <div class="box-header with-border mb-3">
            <h3 class="box-title">
              {{trans('admin.rewardkinds')}}
              <span class="float-right">
                <a class="btn btn-primary" href="{{ url('/admin/rewardkinds/create') }}">{{trans('admin.addrewardkind')}}</a>
              </span>
            </h3>
        </div>

        <div class="box-body">

            @if (Session::has('message'))
              <div class="alert alert-dismissible alert-{{Session::get('rewardkind')}}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                    {{Session::get('message')}}
              </div>
            @endif


            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('admin.title')}}</th>
                            <th scope="col">{{trans('admin.slug')}}</th>
                            <th scope="col">{{trans('admin.rewardkind')}}</th>
                            <th scope="col">{{trans('admin.actions')}}</th>
                        </tr>
                    </thead>



                    <tbody>
                        @if(count($rewardkinds))
                            @foreach($rewardkinds as $rewardkind)
                            <tr>
                                <td>{{$rewardkind->id}}</td>
                                <td>{{@$rewardkind->title[App::getLocale()] }}</td>
                                <td>{{$rewardkind->slug}}</td>
                                <td>
                                      @if($rewardkind->is_active == 1)
                                        <div class="label bg-green">
                                          {{trans('admin.is_active')}}
                                        </div>
                                      @else 
                                        <div class="label bg-red">
                                          {{trans('admin.not_active')}}
                                        </div>
                                      @endif

                                </td>
                                <td class="actions" width="200">
                                  <a class="btn btn-info" href="{{ action('Admin\RewardkindController@edit',$rewardkind->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                                    {{trans('admin.edit')}}
                                  </a>
                                  {{ Form::open(array('url' => 'admin/rewardkinds/' . $rewardkind->id,'style'=>'display:inline')) }}
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


@section('jquery')

@endsection