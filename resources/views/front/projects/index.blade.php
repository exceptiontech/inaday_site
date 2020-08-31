@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <!-- sidebar Begin -->
            <div class="col-12 col-md-4">
                <div class="bg-light rounded pt-3 pb-3 p-2">
                    <!-- block Begin -->
                    <div class="block mb-4">
                        <div class="block-title mb-3">
                            <h2>{{trans('file.category')}}</h2>
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
                    <div class="block mb-4">
                        <div class="block-title mb-3">
                            <h2>{{trans('file.skills')}}</h2>
                        </div>
                        @if (count($skills))
                            @foreach ($skills as $skill)
                                <div class="check-item">
                                    <div class="chicksign">
                                        <label class="che-box">
                                            <input type="checkbox"  class="skillsIds" id="skillId" name="skills[]" value="{{$skill->id}}" aria-required="true"><span class="label-text">
                                          {{ @$skill->title[App::getLocale()] }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- block End -->
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
    <script type="text/javascript">
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
@endsection

