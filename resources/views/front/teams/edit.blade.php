@extends('layouts.inner')
@section('title')
{{__('file.teams')}}

@endsection
@section('content')
<section class="banner">
    <div class="container">
      <h1 class="title"> {{__('forms.edit')}} {{__('file.teams')}} </h1>
    </div>
  </section>


  <section class="signup">
    <div class="container">
      <div class="signupfilde">
        <div class="title-sig">

        </div>
        <form class="formsignup" action="{{ route('front_teams.update',$team->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if(count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissable" >
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4>{{ $error}}</h4>
                    </div>
                @endforeach
            @endif

            
          <div class="row">
            <div class="col-sm-12 inpusrach">
                <label>{{ __('file.team_name') }}<em>*</em></label>
                <input name="title" class="form-control required"  id="firstname"  value="{{ $team->title }}" type="text" placeholder="{{ __('file.team_name') }}" autofocus required="required">
            </div>
            <div class="col-sm-12 inpusrach">
                <label> {{ __('file.team_desc') }}</label>
                <textarea class="form-control required " name="desc" id="lastname" placeholder=" {{ __('file.project_desc') }}" required="required">{{ $team->desc }} </textarea>
            </div>
            @if($team->image)
              <div class="col-sm-2">
                <img class="img-fluid" src="{{url('/'.$team->image)}}">
              </div>
              <div class="col-sm-10 inpusrach">
                  <label> {{ __('file.image') }}<em>*</em></label>
                  <div class="input-group">
                    <label class="input-group-btn"><span class="btn btn-primary">{{ __('file.image') }}
                        <input type="file" name="image"  style="display: none;" ></span></label>
                    <input class="form-control" type="text"  readonly>
                  </div>
              </div>
            @else
              <div class="col-sm-12 inpusrach">
                  <label> {{ __('file.image') }}<em>*</em></label>
                  <div class="input-group">
                    <label class="input-group-btn"><span class="btn btn-primary">{{ __('file.image') }}
                        <input type="file" name="image"  style="display: none;" ></span></label>
                    <input class="form-control" type="text"  readonly>
                  </div>
              </div>

            @endif
          </div>
          <div class="text-center">
              <input type="submit" class="bottom" name="submit" value="{{ __('forms.edit') }}" />
          </div>
        </form>
      </div>
    </div>
  </section>

@endsection
