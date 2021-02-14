@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
    <div class="container">
        <div class="row">

            <div class="col-12 title">
                <h2 class="text-white mb-5">{{trans('file.projects')}}</h2>
            </div>
            <!-- sidebar Begin -->
            <div class="col-12 col-md-4">
                <div class="bg-light rounded pt-3 pb-3 p-2">
                    
                    {{ Form::open(['action' => 'ProjectController@index','method' => 'get']) }}


                    <!-- block Begin -->
                    <div class="block mb-4">
                        <div class="block-title mb-3">
                            <div class="col-12">
                                <h2>{{trans('file.by_section')}} </h2>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="col-12">
                                @if (count($sections))
                                    @foreach ($sections as $section)
                                        <div class="check-item">
                                            <div class="chicksign">
                                                <label class="che-box">
                                                    <input type="checkbox"  class="sectionsId" id="sectionId" name="sections[]" value="{{$section->id}}" aria-required="true"><span class="label-text">
                                                    {{ @$section->title[App::getLocale()] }} </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                    <!-- block End -->

                    <!-- block Begin -->
                    <!-- <div class="block mb-4">
                        <div class="block-title mb-3">
                            <div class="col-12">
                                <h2>{{trans('file.by_skill')}} </h2>
                            </div>
                        </div>
                        <div class="col-12">
                        @if (count($skills))
                            @foreach($skills as $skill)
                            <div class="check-item">
                                <div class="chicksign">
                                    <label class="che-box">
                                    <input @if(in_array($skill->id, $targetskills )) checked="checked" @endif  name="targetskills[]" type="checkbox" value="{{$skill->id}}"> <span class="label-text">
                                      {{$skill->title[App::getLocale()]}} <em>*</em></span>
                                    </label>
                                </div>
                            </div>

                            @endforeach
                        @endif
                        </div>
                    </div> -->
                    <!-- block End -->


                        <!-- block Begin -->
                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <div class="col-12">
                                    <h2>{{trans('file.by_title')}}</h2>
                                </div>
                            </div>
                            <div class="block-content">

                                <div class="col-12">
                                  {!!Form::text('title', Request::get('title'), ['class' => 'form-control']) !!}
                                </div>



                            </div>
                        </div>
                        <!-- block End -->

                    <div class="col-12">

                      {!! Form::button(trans('admin.search'), array('class'=>'btn btn-block btn-success','id'=>'search-button', 'type'=>'submit')) !!}
                    </div>
                    
                    {{ Form::close() }}


                </div>
            </div>
            <!-- sidebar End -->

            <!-- Content Begin -->
            <div class="col-12 col-md-8">
                <div class="bg-light rounded pt-2 pb-3 p-2" id="search-results">
                    @include('front.projects._search')
                </div>
            </div>
            <!-- sidebar End -->
        </div>
    </div>
</div>
<!--     <script type="text/javascript">
        $(document).ready(function () {

            var skillsIds = [];
            var sectionsIds = [];

            // Listen for 'change' event, so this triggers when the user clicks on the checkboxes labels
            $('input.skillsIds, input.sectionsId').on('change', function (e) {
                e.preventDefault();
                skillsIds = []; // reset
                sectionsIds = []; //reset

                $('input[name="skills[]"].skillsIds:checked').each(function()
                {
                    skillsIds.push($(this).val());
                });
                $('input[name="sections[]"].sectionsId:checked').each(function()
                {
                    sectionsIds.push($(this).val());
                });

                $.ajax({
                    type : 'POST',
                    url  : '{!! url("projects/search") !!}',
                    data: {skill_id: skillsIds, section_id: sectionsIds},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (markup) {
                        //console.log(data);
                        $('#search-results').html(markup);
                    },
                });

            });


        });

    </script>
 -->@endsection




@section('jquery')
<script type="text/javascript">

    $(".updateFav").click(function(event) {
        event.preventDefault();
        
        var id = $(this).data("id");
        var data = {'id' : $(this).data("id"),'type' : $(this).data("type")};

        $.ajax({    
            type  : 'get',
            url   : '{!!URL::route('updateFavorite')!!}',
            dataType: 'json',
            data  : data ,      
            success:function(data){

                console.log(data.result);

                if (data.result == 'done') {
                    $('.updateFav'+ id +' .fa').addClass('starred');
                }else {
                    $('.updateFav'+ id +' .fa').removeClass('starred');
                }

            },
        error:function(data){
            console.log(data.err)
        }
      });
    });   


</script>

@endsection

