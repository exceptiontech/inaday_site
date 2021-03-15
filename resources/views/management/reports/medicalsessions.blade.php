@extends('layouts.admin')

@section('title', 'home')

@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{{trans('admin.appointments')}}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
            <li class="breadcrumb-item active">{{trans('admin.appointments')}}</li>
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
                <h4 class="card-title">{{trans('admin.medicalsessions')}}</h4>

            @if (Session::has('message'))
              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                    {{Session::get('message')}}
              </div>
            @endif



            {{ Form::open(['action' => 'AdminController@MedicalsessionsReport','method' => 'get']) }}
                <div  id="searchform" class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                          {!! Form::label('title', trans('admin.name'))!!}
                            {!!Form::text('fullname', null, ['id' => 'fullname','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          {!! Form::label('fromdate', trans('admin.fromdate'))!!}
                            {!!Form::text('fromdate', Request::get('fromdate'), ['id' => 'fromdate','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
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
                        <tr class="">
                            <th scope="col">{{trans('admin.id')}}</th>
                            <th scope="col">{{trans('admin.title')}}</th>
                            <th scope="col">{{trans('admin.patient')}}</th>
                            <th scope="col">{{trans('admin.doctor')}}</th>
                            <th scope="col">{{trans('admin.department')}}</th>
                            <th scope="col">{{trans('admin.status')}}</th>
                            <th scope="col">{{trans('admin.total')}}</th>
                            <th scope="col">{{trans('admin.date')}}</th>
                        </tr>
                    </thead>


                    @if(count($medicalsessions))

                    @foreach($medicalsessions as $medicalsession)
                    <tr class="">
                        <td>{{$medicalsession->id}}</td>
                        <td>{{$medicalsession->name}}</td>
                        <td>@if($medicalsession->appointment->patient){{$medicalsession->appointment->patient->fullname}} @endif</td>
                        <td>@if($medicalsession->appointment->doctor){{$medicalsession->appointment->doctor->fullname}}@endif</td>
                        <td>@if($medicalsession->appointment->status){{$medicalsession->appointment->status->name}}@endif</td>

                        <td>@if($medicalsession->appointment->department){{$medicalsession->appointment->department->name}} @endif</td>
                        <td>
                            {{$medicalsession->price}}
                        </td>
                        <td>
                            {{$medicalsession->date}}
                        </td>

                    </tr>
                    @endforeach

                    <tr class="bg-info text-white font-weight-bolder">
                        <td colspan="7">
                            @lang('admin.total')
                        </td>
                        <td colspan="2">
                            {{$total}} {{trans('admin.riyal')}}
                        </td>
                    </tr>


                    @else
                    <tr>
                    	<td colspan="9">{{trans('admin.no_items')}}</td>
                    </tr>
                    @endif
                  </table>
                  {{ $medicalsessions->appends(request()->input())->links() }}

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