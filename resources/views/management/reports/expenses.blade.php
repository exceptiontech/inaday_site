@extends('layouts.admin')

@section('title', 'home')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{{trans('admin.expenses')}}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.expenses')}}</li>
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
                <h4 class="card-title">{{trans('admin.expenses')}}</h4>

                @if (Session::has('message'))
                  <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                        {{Session::get('message')}}
                  </div>
                @endif


            {{ Form::open(['action' => 'AdminController@ExpensesReport','method' => 'get']) }}
                <div  id="searchform" class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                          {!! Form::label('title', trans('admin.name'))!!}
                            {!!Form::text('fullname', null, ['id' => 'fullname','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                          {!! Form::label('title', trans('admin.ecategories'))!!}
                            {!!Form::select('ecategory_id', $ecategories, null, ['id' => 'doctor','class' => 'form-control','placeholder'=>'all']) !!}
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
                                <th>@lang('admin.id')</th>
                                <th>@lang('admin.name')</th>
                                <th>@lang('admin.category')</th>
                                <th>@lang('admin.date')</th>
                                <th>@lang('admin.mount')</th>
                                <th>@lang('admin.accountant')</th>

                            </tr>
                        </thead>
                        
                        <tbody>
                            @if (count($expenses) > 0)
                                @foreach ($expenses as $expense)
                                    <tr data-entry-id="{{ $expense->id }}">
                                        <td field-key='id'>{{$expense->id}}</td>
                                        <td field-key='entry_date'>{{$expense->name}}</td>
                                        <td field-key='expense_category'>{{$expense->ecategory->name}}</td>
                                        <td field-key='entry_date'>{{$expense->entry_date}}</td>
                                        <td field-key='amount'>{{$expense->amount}}</td>
                                        <td field-key='amount'>{{$expense->user->fullname}}</td>

                                    </tr>
                                @endforeach

                                    <tr class="bg-info text-white font-weight-bolder">
                                        <td colspan="5">
                                            @lang('admin.total')
                                        </td>
                                        <td colspan="2">
                                            {{$total}} {{trans('admin.riyal')}}
                                        </td>
                                    </tr>
                            @else
                                <tr>
                                    <td colspan="7">
                                        {{trans('admin.no_items')}}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                  {{ $expenses->appends(request()->input())->links() }}

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