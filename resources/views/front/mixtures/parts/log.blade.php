<div class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">
        @if($log->user->isAdmin() )
            {{trans('file.administrator')}}
        @else
            {{ $mixture->team->user->first_name.' '.$mixture->team->user->last_name }}
        @endif        
      </h5>
      <small>{{ Carbon\Carbon::parse(strtotime($log->created_at))->format('d-m-Y') }}</small>
    </div>


  <p class="mb-2">{{$log->desc}}</p>

  @if(Auth::user()->isAdmin())
  @if($log->action == 'create' || $log->action == 'update' )
    @if($mixture->ModelLogs->last()->id == $log->id)


    <a class="btn btn-info" href="{{ action('Admin\MixtureController@approve',$mixture->id) }}" data-toggle="tooltip" title="{{trans('admin.approve')}}">
      {{trans('admin.approve')}}
    </a>

    <a class="btn btn-danger text-white" data-toggle="modal" data-target="#item">
      {{trans('admin.refuse')}}
    </a>

    <div class="modal fade" id="item"  role="dialog" aria-labelledby="itemLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="col-12"> 
        {{ Form::open(['action' => 'Admin\MixtureController@refuse']) }}
        <div class="modal-content">

          <div class="modal-body">

            {!! Form::hidden('model_id', $mixture->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

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
    </div>  
  @endif
  @endif
  @endif
</div>
