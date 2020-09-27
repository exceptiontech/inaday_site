        {{ Form::open(['action' => 'ReplayController@store','files'=>true]) }}
                                    
        {!! Form::hidden('booking_id', $replay->booking->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

        {!! Form::hidden('replay_id', $replay->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                                    
        @if(count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissable" >
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ $error}}
                </div>
            @endforeach
        @endif

        <div class="block col-12 pt-3 pb-2 mb-3 border-0">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="mb-3 dark">الاجراء</h2> 
                </div>
                <div class="col-sm-12 mb-4">
                    <div class="col-12 mb-4">طلب تمديد مهلة لمدة {{$replay->duration}} ساعة</div>

                    <div class="col-12">
                    <div class="form-check form-check-inline ml-4">
                      <input class="form-check-input" type="radio" name="is_confirmed" id="approve" value="1">
                      <label class="form-check-label" for="approve">موافق على طلب المهلة</label>
                    </div>
                    <div class="form-check form-check-inline ml-4">
                      <input class="form-check-input" type="radio" name="is_confirmed" id="refuse" value="-1">
                      <label class="form-check-label" for="refuse">غير موافق</label>
                    </div>
                    </div>
                </div>

                <div class="col-sm-12 mb-4">
                    <label><b>ملاحظات</b></label>
                    {!! Form::textarea('replay', null,  array('required', 'class'=>'textarea form-control', 'rows'=>'2')) !!}
                </div>


            </div>
        </div>


    <div class=" mb-3">
        <div class="col-12">
          {!! Form::submit('إرسال', array('class'=>'btn btn-primary')) !!}
        </div>
    </div>
{{ Form::close() }}                  
