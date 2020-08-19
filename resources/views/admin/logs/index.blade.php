@extends('layouts.admin')

@section('title', 'home')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{{trans('admin.logs')}}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.logs')}}</li>
        </ol>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> {{trans('admin.print')}}</button>
    </div>
</div>
<div class="row">
    <!-- column -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans('admin.logs')}}</h4>

                {{ Form::open(['action' => 'LogsController@index','method' => 'get']) }}
                    <div  id="searchform" class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                              {!! Form::label('user_id', trans('admin.employee'))!!}
                                {!!Form::select('user_id',$users, Request::get('action'), ['id' => 'doctor','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              {!! Form::label('model', trans('admin.model'))!!}
                                {!!Form::select('model', ['department'=>trans('admin.department'),'city'=>trans('admin.city'),'payment'=>trans('admin.payment'),'Treasury'=>trans('admin.treasury'),'country'=>trans('admin.country'),'accountant'=>trans('admin.accountant'),'medicalsession'=>trans('admin.medicalsessions'),'appointment'=>trans('admin.appointment'),'nurse'=>trans('admin.nurses'),'doctor'=>trans('admin.doctor'),'invoice'=>trans('admin.invoice'),'income'=>trans('admin.incomes'),'expense'=>trans('admin.expenses'),'icategory'=>trans('admin.icategories'),'ecategory'=>trans('admin.ecategories')], Request::get('model'), ['id' => 'doctor','class' => 'form-control','placeholder'=>trans('admin.please_select')]) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              {!! Form::label('action', trans('admin.action'))!!}
                                {!!Form::select('action', ['create'=>trans('admin.create'),'update'=>trans('admin.update'),'delete'=>trans('admin.delete')], Request::get('action'), ['id' => 'doctor','class' => 'form-control','placeholder'=>trans('admin.please_select')]) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              {!! Form::label('fromdate', trans('admin.fromdate'))!!}
                                {!!Form::text('fromdate', Request::get('fromdate'), ['id' => 'fromdate','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              {!! Form::label('todate', trans('admin.todate'))!!}
                                {!!Form::text('todate', Request::get('todate'), ['id' => 'todate','class' => 'form-control']) !!}
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

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{trans('admin.employee')}}</th>
                                <th scope="col">{{trans('admin.model')}}</th>
                                <th scope="col">{{trans('admin.action')}}</th>
                                <th scope="col">{{trans('admin.url')}}</th>
                                <th scope="col">{{trans('admin.date')}}</th>
                                <th scope="col">{{trans('admin.ip')}}</th>
                            </tr>
                        </thead>



                        <tbody>
                            @if(count($logs))
                                @foreach($logs as $log)
                                <tr>
                                    <td>{{$log->id}}</td>
                                    <td>{{$log->user->name}}</td>
                                    <td>{{$log->model}}</td>
                                    <td>
                                        @if($log->action == 'delete' )
                                            {{trans('admin.delete')}}
                                        @elseif($log->action == 'create' )
                                            {{trans('admin.create')}}
                                        @elseif($log->action == 'update' )
                                            {{trans('admin.update')}}
                                        @endif

                                    </td>
                                    <td>{{$log->url}}</td>
                                    <td>{{$log->created_at}}</td>
                                    <td>{{$log->ip}}</td>

                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">
                                        {{trans('admin.no_items')}}
                                    </td>
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
<style type="text/css">
@media print {
  .left-sidebar , #searchform , .page-titles {
    display: none !important;
  }
}

</style>

<script type="text/javascript">

    
    $('#printInvoice').click(function(){
        Popup($('#results')[0].outerHTML);
        function Popup(data) 
        {
            window.print();
            return true;
        }
    });


  $('#fromdate').datepicker({
    language: 'en',
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

  $('#todate').datepicker({
    language: 'en',
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

</script>
@endsection