@extends('layouts.admin')

@section('content')

<div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="box box-warning">
        <div class="box-header with-border mb-3">
            <h3 class="box-title">
              {{trans('admin.interviews')}}
              @can('interview-create')
              <span class="float-right">
                <a class="btn btn-primary" href="{{ url('/admin/interviews/create') }}">{{trans('admin.addinterview')}}</a>
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('admin.user')}}</th>
                            <th scope="col">{{trans('admin.skill')}}</th>
                            <th scope="col">{{trans('admin.is_passed')}}</th>
                            <th scope="col">{{trans('admin.total')}}</th>
                            <th scope="col">{{trans('admin.actions')}}</th>
                        </tr>
                    </thead>



                    <tbody>
                        @if(count($interviews))
                            @foreach($interviews as $interview)
                            <tr>
                                <td>{{$interview->id}}</td>
                                <td>
                                  {{$interview->user->first_name .' ' .$interview->user->last_name }}
                                </td>
                                <td>
                                  {{$interview->skill->title[App::getLocale()] }}
                                </td>
                                <td>
                                  @if($interview->is_passed)
                                    {{trans('admin.passed')}}
                                  @else
                                    {{trans('admin.failed_or_not_passed')}}
                                  @endif
                                </td>
                                <td>
                                  {{$interview->total}}
                                </td>
                                <td class="actions" width="200">
                                  <a class="btn btn-info" href="{{ action('Admin\InterviewController@edit',$interview->id) }}" data-toggle="tooltip" title="{{trans('admin.edit')}}">
                                    {{trans('admin.edit')}}
                                  </a>
                                  {{ Form::open(array('url' => 'admin/interviews/' . $interview->id,'style'=>'display:inline')) }}
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