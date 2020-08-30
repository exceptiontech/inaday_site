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
                                <h2>حسب تصنيف الأقسام</h2>
                            </div>
                            <div class="block-content">

                                <div class="col-12">
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="1" aria-required="true"><span class="label-text">
                                         تصميم الهوية البصرية<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="2" aria-required="true"><span class="label-text">
                                         تصميم وبرمجة المنصات الالكترونية<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="3" aria-required="true"><span class="label-text">
                                         تخليص المستندات الحكومية<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="4" aria-required="true"><span class="label-text">
                                         تصميم العروض التقديمية<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="5" aria-required="true"><span class="label-text">
                                         تصميم المواقع الالكترونية<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="6" aria-required="true"><span class="label-text">
                                         تصميم الحملات الاعلانية<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="7" aria-required="true"><span class="label-text">
                                         تصميم الالعاب الالكترونية<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="check-item">
                                        <div class="chicksign">
                                            <label class="che-box">
                                                <input class="required" type="checkbox" id="experience" name="skills[]" value="8" aria-required="true"><span class="label-text">
                                         دراسة جدوى للمشاريع<em>*</em></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <!-- block End -->

                        <!-- block Begin -->
                        <div class="block mb-4">
                            <div class="block-title mb-3">
                                <h2>حسب الكلمات المفتاحية</h2>
                            </div>
                            <div class="block-content">
                                كلمات مفتاحية
                            </div>
                        </div>
                        <!-- block End -->


                    </div>
                </div>
                <!-- sidebar End -->


                <!-- Content Begin -->
                <div class="col-12 col-md-8">
                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="row">

                            <!-- services provider begin  -->
                            @if(count($users))
                                @foreach($users as $user)
                            <div class="col-12 col-md-4 mb-5 mt-5 provider-block">
                                <div class="bg-light rounded text-center">
                                    <img class="w-50 mt-n5" src="images/19571f92333dd5fba2598f637b68739c.png" alt="" class="rounded-circle" >
                                    <div class="text p-2 pt-0">
                                        <h2 class="mb-3">  {{ $user->first_name .' '.$user->last_name }}</h2>
                                        <p class="position"> {{ $user->userdetail->position }}</p>
                                        <p class="location">{{ $user->userdetail->country->title['ar'] }}/..</p>

                                        <a class="btn btn-primary mt-4" href="#">مشاهدة الملف الشخصي</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- services provider end  -->
                        </div>

                        <!-- pagination begin -->
                        <div class="col-12">
                            {{ $users->links() }}
{{--                            <nav aria-label="Page navigation example">--}}
{{--                                <ul class="pagination justify-content-center">--}}
{{--                                    <li class="page-item disabled">--}}
{{--                                        <a class="page-link" href="#" tabindex="-1"><<</a>--}}
{{--                                    </li>--}}
{{--                                    <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>--}}
{{--                                    <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                    <li class="page-item">--}}
{{--                                        <a class="page-link" href="#">>></a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </nav>--}}
                        </div>
                        <!-- pagination end -->


                    </div>
                </div>
                <!-- sidebar End -->

            </div>
        </div>
    </div>
@endsection
