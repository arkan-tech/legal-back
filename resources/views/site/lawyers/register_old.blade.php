@extends('site.layouts.main')
@section('title', 'التسجيل في منصة يمتاز')
@section('content')
    <style>
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20rem;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20rem;
        }

        #image-select {
            background-repeat: no-repeat;
            background-position: center right;
            background-size: 20px 20px;
            padding-right: 25px;
            /* background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAHmSURBVHja7JfBahRBEEBf7c4ShCQDQgiB/IF48S7+gBfx5C8oiJ8ign5BQATBi5/gzaOHfIAHNQuKxtnsTndXeZjJzmwys5MZtfeSunRPU1Pzqrqqu0bMjE3KiA3LNYAAY2CrHGNKABYJsGtm34da+frw0cDYCwdvX99MgLRN5+eLV8t5+vRxo86Ne3cHfT8/PgZIkzL8zTE6mUJHmYZvJw0bK8V4/q7Iip1RmsLCAWwl64zbfN7piS0Wvb23+RzzDoBLANMnzxpfqq/vvXy+nOvZWf/4TyZo3gJgPQ3aAABLEvC+BSDL+hnrqQ9ggOV5M8D+m6Pl/Mv9B8v5wft3jcZ0CIAZlLmzNgn196w4quwKOueuyQVX5fK6BAWXdwNYllUl9Rc6NdcLXeexthyoy+HHD902ZwOqIHcwHlUAn2/dIWQzcC7OLTCZMN7dqQDUewgBVCNdQwF1tS0w7xFTLBKAmK6ehMF7ErN4ETBDXQ1Ancew/hG4WKLSUH4tAKG+BRo8jJPOm6/xSGt7tvXkIawAaNEPReyQNWjVEwbVqx8m/yQLBdUagJohEQGkBlCUoRURGG1vx9sCqwCCAj9Of0VtictsCwLsA7eBvcht+RT4JGVTurOuOf1PsgBO5frndNMAfwYAatvke8jV11wAAAAASUVORK5CYII='); */
        }
    </style>

    <!-- Contact Form Section -->
    <section class="register-section" onload="AamirFunction();">
        <div class="auto-container">
            <div class="row clearfix">

                <!--Form Column-->
                <div class="form-column column col-lg-9 col-md-12 col-sm-12">

                    <!--Form Column-->
                    <div class="form-column column col-lg-12 col-md-12 col-sm-12">
                        <div class="sec-title">
                            <h2>سجل بياناتك هنا</h2>
                            <div class="separate"></div>
                        </div>
                        <!--Login Form-->
                        <div class="styled-form register-form">
                            <form action="{{route('site.lawyer.save.register.data')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <span style="left: 25px" class="adon-icon">
                                                <span class="fa fa-user"></span>
                                            </span>
                                            <input type="text" id="fname" name="fname" value=""
                                                   placeholder="الاسم الأول">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text fname_err">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <span style="left: 25px" class="adon-icon"><span
                                                    class="fa fa-user"></span></span>
                                            <input type="text" id="sname" name="sname" value=""
                                                   placeholder="الاسم الثانى">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text sname_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <span style="left: 25px" class="adon-icon"><span
                                                    class="fa fa-user"></span></span>
                                            <input type="text" name="tname" id="tname" value=""
                                                   placeholder="الاسم الثالث">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text tname_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <span style="left: 25px" class="adon-icon"><span
                                                    class="fa fa-user"></span></span>
                                            <input type="text" name="fourthname" id="fourthname" value=""
                                                   placeholder="الاسم الرابع">

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text fourthname_err"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                    <input type="text" id="bio" name="bio" value=""
                                           placeholder="تعريف مختصر">
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group" id="birthday" style="padding: 8px 10px">
                                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                                            <input type="date" name="birthday" value=""
                                                   placeholder="تاريخ الميلاد ">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text birthday_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                            <select id="gender" name="gender">
                                                <option value="">النوع</option>
                                                <option value="Male">ذكر</option>
                                                <option value="Female">أنثى</option>
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text gender_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                                            <select id="type" name="type" onchange="licencesfun(event)">
{{--                                                <option value="">الجهة</option>--}}
                                                <option value="1">فرد</option>
                                                <option value="2">مؤسسة</option>
                                                <option value="3">شركة</option>
                                                <option value="4">جهة حكومية</option>
                                                <option value="5">هيئة</option>
                                                <option value="6">أخرى</option>
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text type_err"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="div_company_name" style="display: none;">
                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                    <input type="number" name="company_name" id="company_name" value=""
                                           placeholder="اسم  تجاري">

                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text company_name_err"></span>
                                </div>
                                <div class="form-group" id="div_lisences" style="display: none;">
                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                    <input type="number" name="lisences" id="lisences" value=""
                                           placeholder="الترخيص">

                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text lisences_err"></span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                            <select id="country" name="country">
                                                <option value="">الدولة</option>
                                                <?= GetSelectItem('countries', 'name', '') ?>
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text country_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                            <select id="country-nationality" name="nationality">
                                                <option value="">الجنسية</option>
                                                @foreach ($countries as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                                <!-- Add more options for each country you want to include -->
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text nationality_err"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                            <select id="city" name="city" onchange="cityfun(event)">
                                                <option value="">المدينة</option>
                                                <option value="0">أخرى</option>
                                            </select>

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text city_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-6" style="display: none;" id="dev_city">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                                            <input type="number" name="else_city" id="else_city" value=""
                                                   placeholder=" مدينه اخرى">

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text else_city_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                                            <input type="number" name="town" id="town" value=""
                                                   placeholder="المنطقة">

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text town_err"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <select id="image-select" name="code">
                                                @foreach ($countries->whereNotNull('phone_code') as $item)
                                                    <option value="{{ $item->code }}" data-image="{{ $item->flag }}">+
                                                        {{ $item->phone_code }}</option>
                                                @endforeach
                                                <!-- Add more options for each country you want to include -->
                                            </select>
                                        </div>
                                        <div class="col-9"> <span class="adon-icon"><span
                                                    class="fa fa-mobile"></span></span>
                                            <input type="number" name="mobile" id="mobile" value="" maxlength="10"
                                                   pattern="\d*"
                                                   placeholder="رقم الجوال">
                                        </div>
                                    </div>


                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text mobile_err"></span>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                                            <select id="type" name="identity_type" onchange="identityfun(event)">
                                                <option value="">نوع الهوية</option>
                                                <option value="1">هوية وطنيه</option>
                                                <option value="2"> جواز السفر</option>
                                                <option value="3"> هويه مقيم</option>
                                                <option value="4"> اخرى</option>

                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text type_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group" id="div_other_idetity_type" style="display: none;">
                                            <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                            <input type="text" name="other_idetity_type" id="other_idetity_type"
                                                   value=""
                                                   placeholder="نوع الهويه المطلوبه ">

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text other_idetity_type_err"></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-user"></span></span>
                                            <input type="number" name="NatID" id="NatID" value=""
                                                   minlength="10" placeholder="رقم الهوية">

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text NatID_err"></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                    <select id="degree" name="degree" onchange="sesnfun(event)">
                                        <option value="">الدرجة العلمية</option>
                                        <?= GetSelectItem('degrees', 'title', '') ?>
                                    </select>

                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text degree_err"></span>
                                </div>
                                <div class="form-group" id="div_other_note" style="display: none;">
                                    <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                    <input type="text" name="other_note" id="other_note" value=""
                                           placeholder="اذكر الدرجات العلميه الاخرى هنا  ">

                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text other_note_err"></span>
                                </div>
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                    <select name="sections[]" multiple="multiple" id='sections'>

                                        @foreach (getSections() as $section)
                                            <option value="{{ $section->id }}"> {{ $section->title }} </option>
                                        @endforeach
                                    </select>

                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text sections_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="toggle"> هل لديك رقم ترخيص </label>
                                    <input type="checkbox" onchange="licfun(event)" id="toggle" data-toggle="toggle"
                                           data-style="ios">
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text LicenceNo_err"></span>
                                </div>
                                <div class="form-group" id="div_LicenceNo" style="display: none;">
                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                    <input type="number" name="LicenceNo" id="LicenceNo" value=""
                                           placeholder="رقم الترخيص">

                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text LicenceNo_err"></span>
                                </div>


                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-envelope-o"></span></span>
                                    <input type="email" name="email" id="email" value=""
                                           placeholder="البريد الالكتروني">
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text email_err"></span>
                                </div>
                                <div class="form-group">
                                    <span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>
                                    <input type="password" name="password" id="password" value=""
                                           placeholder="كلمة المرور">
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text password_err"></span>
                                </div>

                                <div class="form-group">
                                    <label for="file"> الإحداثيات </label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>
                                            <input type="text" readOnly id="lat" name="lat" value=""
                                                   placeholder="خط الطول">
                                        </div>
                                        <div class="col-md-6">
                                            <span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>
                                            <input type="text" readOnly id="lon" name="lon" value=""
                                                   placeholder="خط العرض">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div style="height: 300px; width: 100%" id='map-canvas'></div>
                                </div>

                                <div class="form-group">
                                    <label for="file">الصوره الشخصيه او الشعار</label>
                                    <input type="file" name="file" class="form-control" id="file">
                                    <label for=""> بمعاير PNG,JPGيرجى التحق من صوره واضحه بمقاس متوسط</label>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text file_err"></span>
                                </div>

                                <div class="form-group">
                                    <label for="id_file"> ارفاق نسخة من الهوية </label>
                                    <input type="file" name="id_file" class="form-control" id="id_file">
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text id_file_err"></span>
                                </div>

                                <div class="form-group">
                                    <label for="license_file">"ارفاق نسخة من الترخيص "</label>
                                    <input type="file" name="license_file" class="form-control" id="license_file">
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text license_file_err"></span>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="rules" id="rules">
                                    <label for="rules">
                                        الموافقه على ميثاق الانضمام للتطبيق ؟ <a href="/lawyers-rules">الإطلاع على
                                            البنود.</a>
                                    </label>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text rules_err"></span>
                                </div>
                                <div class="clearfix">
                                    <div class="form-group pull-left">
                                        <button type="submit" class="theme-btn btn-style-three register-submit"><span
                                                class="txt">سجل هنا</span></button>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <div class="alert alert-success alert-block" style="display: none;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong class="success-msg"></strong>
                                        </div>
                                    </div>
                                    <div class="form-group submit-text pull-right">
                                        لا يجوز لك استخدام، أو حث الآخرين على استخدام، أي نظام مميكن أو برنامج إلكتروني
                                        لاستخراج محتوى أو بيانات من موقعنا الإلكتروني باستثناء الحالات التي تدخل فيها
                                        أنت
                                        شخصياً، أو يدخل فيها أي طرف ثالث معني طرفاً في اتفاق خطي معنا يُجيز هذا الفعل
                                        صراحة
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
    </section>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdhYBtJu-w2JmuMNQDZsmXIHRkj8uGQhw&callback&callback=initMap&amp;language=ar-AR">
    </script>
    <script type="text/javascript">
        function initMap() {
            var myLatlng = new google.maps.LatLng(30.0444, 31.2357);
            var myOptions = {
                zoom: 10,
                center: myLatlng
            }

            var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
            var geocoder = new google.maps.Geocoder();

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable: true,
                title: "Drag me!"
            });

            marker.addListener('dragend', function (event) {

                $('#lat').val(event.latLng.lat());
                $('#lon').val(event.latLng.lng());

                geocoder.geocode({
                    'latLng': event.latLng
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            //alert(results[0].formatted_address);
                            $('#Settings_address').val(results[0].formatted_address);
                        }
                    }
                });

            });


            google.maps.event.addListener(map, 'click', function (event) {
                geocoder.geocode({
                    'latLng': event.latLng
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            alert(results[0].formatted_address);
                        }
                    }
                });
            });
        }
    </script>
    <script>
        function sesnfun(event) {
            var div = document.getElementById("div_other_note");

            if (event.target.value == 4) {
                // $('#div_other_note').att
                if (div.style.display === "none") {
                    div.style.display = "block";
                } else {
                    div.style.display = "none";
                }
                // document.getElementById("div_other_note").style.display = "block";
            } else {
                if (div.style.display === "none") {
                    // div.style.display = "block";
                } else {
                    div.style.display = "none";
                }
            }
        }

        function licfun(event) {
            var div = document.getElementById("div_LicenceNo");
            if (event.target.value == 'on') {
                // $('#div_other_note').att
                if (div.style.display === "none") {
                    div.style.display = "block";
                } else {
                    div.style.display = "none";
                }
                // document.getElementById("div_other_note").style.display = "block";
            } else {
                if (div.style.display === "none") {
                    // div.style.display = "block";
                } else {
                    div.style.display = "none";
                }
            }
        }

        function licencesfun(event) {
            var div_com = document.getElementById("div_company_name");
            var div_lic = document.getElementById("div_lisences");
            if (event.target.value == 1 || event.target.value == "") {
                div_com.style.display = "none"
                div_lic.style.display = "none"

            } else {
                div_com.style.display = "block"
                div_lic.style.display = "block"
            }
        }

        function cityfun(event) {
            var div_city = document.getElementById("dev_city");
            if (event.target.value != 0 || event.target.value == "") {
                div_city.style.display = "none"

            } else {
                div_city.style.display = "block"
            }
        }

        function identityfun(event) {
            var div_city = document.getElementById("div_other_idetity_type");
            if (event.target.value == 4) {
                div_city.style.display = "block"

            } else {
                div_city.style.display = "none"
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#image-select option').each(function () {
                var $opt = $(this);
                var value = $opt.val();
                var text = $opt.text();
                var image = $opt.data('image');
                // console.log('url('+image+')');
                // $opt.css('background-image', 'url('+image+')');
                // $opt.attr('style', 'background-image: url(' + image + ')');
                $opt.style = "background-image: url(" + image + ")";
            });
        });
    </script>

@endsection
