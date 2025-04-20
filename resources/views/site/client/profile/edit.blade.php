@extends('site.layouts.main')
@section('title',' حسابى الشخصى ')
@section('content')

    <style>
        .apply-office {
            font-family: 'Tajawal Bold';
        }

        .links {
            font-size: 20px;
            font-weight: 700
        }

        .links:hover {
            color: #dd9b25
        }

        a.active {
            color: #000
        }

        .table-inbox {
            border: 1px solid #d3d3d3;
            margin-bottom: 0;
        }

        .table > tbody > tr > td {
            border-top: 1px solid #ddd;
        }

        .table-inbox tr td {
            padding: 15px !important;
            vertical-align: middle;
            text-align: center;
        }

        .inbox-head {
            background: none repeat scroll 0 0 #dd9b25;
            border-radius: 0 4px 0 0;
            color: #fff;
            min-height: 80px;
            padding: 20px;
        }

        .avatar {
            width: 50px;
            border-radius: 50%;
        }
    </style>

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">


                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <h2> الملف الشخصى </h2>
                        <div class="separate"></div>
                    </div>

                    <div class="p-5">
                        <form id="client-update-profile-form" method="post"
                              action="{{route('site.client.profile.update')}}">


                            @csrf
                            <input type="hidden" name="id" value="{{$client->id}}">
                            <div class="row ">
                                <div class="col-lg-6">
                                    <label for="">الاسم بالكامل</label>
                                    <input type="text" name="myname" value="{{$client->myname}}" id="myname"
                                           class="form-control"
                                           placeholder="الاسم بالكامل">
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_myname_error"></span>
                                </div>
                                <div class="col-lg-6">
                                    <label for=""> رقم الجوال</label>

                                    <div class="input-group">
                                        <div class="input-group-append">

                                            <select class="form-control select2" required name="phone_code"
                                                    id="phone_code">
                                                @foreach($countries as $country)
                                                    <option
                                                        value="{{$country->phone_code}}" {{$client->phone_code == $country->phone_code ?'selected':''}}>{{$country->name. ' '.'('.$country->phone_code.' )'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="number" name="mobile" id="mobile"
                                               class="form-control"
                                               minlength="9"
                                               pattern="[0-9]"
                                               min="0"
                                               value="{{str_replace($client->phone_code,'',$client->mobil)}}"
                                               oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                               maxlength="9">
                                    </div>

                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_mobile_error"></span>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_phone_code_error"></span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4">
                                    <label for=""> الدولة</label>

                                    <select class="form-control select2" required name="country_id" id="country_select">
                                        <option value="0">-- اختر --</option>
                                        @foreach($countries as $country)
                                            <option
                                                value="{{$country->id}}" {{$client->country_id ==$country->id ?'selected':'' }} >{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_country_id_error"></span>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label> المنطقة :</label>
                                        <select id="region_id" name="region_id"
                                                class="form-control select2">
                                            @include('site.client.includes.region-select')
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text client_register_region_id_error">
                                            </span>

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label> المدينة :</label>
                                        <select id="city" name="city"
                                                class="form-control select2">
                                            @include('site.client.includes.cities-select')
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text client_register_city_error">
                                    </span>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label for=""> الجنسية</label>
                                    <select class="form-control select2" required name="nationality_id">
                                        @foreach($nationalities as $nationality)
                                            <option
                                                value="{{$nationality->id}}" {{$client->nationality_id ==$nationality->id?'selected':''}}>{{$nationality->name}}</option>
                                        @endforeach
                                    </select>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_nationality_id_error"></span>
                                </div>
                                <div class="col-lg-4">
                                    <label for=""> الجنس</label>
                                    <select id="gender" name="gender"
                                            class="form-control select2 ">
                                        <option value=""> -- اختر --</option>
                                        <option value="Male" {{$client->gender =='Male'?'selected':''}}>ذكر
                                        </option>
                                        <option {{$client->gender =='Female'?'selected':''}}  value="Female">أنثى
                                        </option>
                                    </select>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_gender_error"></span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for=""> البريد الالكتروني</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           placeholder="البريد الالكتروني" value="{{$client->email}}">
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_email_error"></span></div>
                                <div class="col-lg-6">

                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">كلمة المرور</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge" id="password"
                                               name="password" tabindex="2"
                                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                               aria-describedby="login-password"/>
                                        <span class="input-group-text cursor-pointer">
                                            <span id="togglePassword" class="adon-icon"><span
                                                    class="fa fa-eye-slash"></span></span></span>

                                    </div>


                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text client_register_password_error"></span></div>
                            </div>

                            <div class="row mt-3">
                                <label for=""> الصفة</label>
                                <select class="form-control" id="type" name="type" style="height: 50px">
                                    <option value="1" {{$client->type ==1?'selected':''}}>فرد</option>
                                    <option value="2" {{$client->type ==2?'selected':''}}>مؤسسة</option>
                                    <option value="3" {{$client->type ==3?'selected':''}}>شركة</option>
                                    <option value="4" {{$client->type ==4?'selected':''}}> جهة حكومية</option>
                                    <option value="5" {{$client->type ==5?'selected':''}}>هيئة</option>
                                </select>
                                <span style="display: block;text-align: right;"
                                      class="text-danger error-text client_register_type_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="file"> الإحداثيات </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" readOnly id="lat" name="longitude"
                                               class="form-control"
                                               placeholder="خط الطول">
                                        <span style="text-align: right;"
                                              class="text-danger error-text client_register_longitude_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" readOnly id="lon" name="latitude"
                                               class="form-control"
                                               placeholder="خط العرض">

                                        <span style="text-align: right;"
                                              class="text-danger error-text client_register_latitude_error"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div style="height: 300px; width: 100%" id='client-map-canvas'></div>
                            </div>

                            <div class="form-group mt-3">
                                <input type="checkbox" name="rules" id="rules" required>
                                <label for="rules">
                                    الموافقه على ميثاق الانضمام للتطبيق ؟
                                    <a href="{{route('site.lawyers.rules')}}">الإطلاع
                                        على البنود.</a>
                                </label>
                                <span style="display: block;text-align: right;"
                                      class="text-danger error-text client_register_rules_error"></span>
                            </div>

                            <div class="clearfix">
                                <div class="form-group text-center">
                                    <button type="submit" class="theme-btn btn-style-three "
                                            id="update_client_btn"><span
                                            class="txt">سجل هنا</span></button>
                                </div>
                                <br>
                                <div class="form-group submit-text pull-right">
                                    لا يجوز لك استخدام، أو حث الآخرين على استخدام، أي نظام مميكن أو برنامج إلكتروني
                                    لاستخراج
                                    محتوى أو بيانات من موقعنا الإلكتروني باستثناء الحالات التي تدخل فيها أنت شخصياً، أو
                                    يدخل
                                    فيها أي طرف ثالث معني طرفاً في اتفاق خطي معنا يُجيز هذا الفعل صراحة
                                </div>
                            </div>

                        </form>
                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection
@section('site_scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdhYBtJu-w2JmuMNQDZsmXIHRkj8uGQhw&callback&callback=initMap&amp;language=ar-AR">
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementsByClassName('client_register_email_error');
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');
            emailInput.addEventListener('input', function (event) {
                const enteredText = event.target.value;
                const isValid = isEnglish(enteredText);

                if (!isValid) {
                    emailInput.value = removeNonEnglishCharacters(enteredText);
                    emailError.textContent = 'الرجاء ادخال احرف انجليزية فقط.';
                } else {
                    emailError.textContent = '';
                }
            });

            function isEnglish(text) {
                return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(text);
            }

            function removeNonEnglishCharacters(text) {
                return text.replace(/[^a-zA-Z0-9._%+-@]/g, '');
            }


            togglePasswordButton.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePasswordButton.text = '<span class="adon-icon"><span class="fa fa-eye-slash"></span></span>';
                } else {
                    passwordInput.type = 'password';
                    togglePasswordButton.text = '<span class="adon-icon"><span class="fa fa-eye"></span></span>';
                }
            });
        });


        $('#phone_code').on('change', function () {
            let value = $(this).val();
            if (value == 966) {
                $('#mobile').attr('maxLength', 9);
            } else {
                $('#mobile').attr('maxLength', 10);
            }
        });


        function initMap() {
            var myLatlng = new google.maps.LatLng('{{$client->latitude}}', '{{$client->longitude}}');
            var myOptions = {
                zoom: 10,
                center: myLatlng
            }
            var map = new google.maps.Map(document.getElementById("client-map-canvas"), myOptions);
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

        $('#country_select').on('change', function () {
            let country_id = $(this).val();
            let actionUrl = '{{route('site.client.get-regions-bade-country-id')}}' + '/' + country_id;
            let region_id;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#region_id').html(response.items_html);
                }
                if (response.first_region != null) {
                    region_id = response.first_region.id;
                } else {
                    region_id = 0;
                }
                let actionUrl_region = '{{route('site.client.get-cities-bade-country-id')}}' + '/' + region_id;
                $.get(actionUrl_region, function (response) {
                    if (response.status) {
                        $('#city').html(response.items_html);
                    }
                });

            });

        });
        $('#region_id').on('change', function () {
            let region_id = $(this).val();
            let actionUrl = '{{route('site.lawyer.get-cities-bade-region-id')}}' + '/' + region_id;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#city').html(response.items_html);
                }
            });
        });


        function getFormInputs(formId) {
            return new FormData(formId[0]);
        }

        function disableAndLoadingButton(selector, loadingText) {
            selector.attr('disabled', true).html('<div class="fa fa-spinner fa-spin"></div> ' + loadingText);
        }

        function enableAndLoadingButton(selector, normalText) {
            selector.attr('disabled', false).html(normalText);
        }

        $('#client-update-profile-form').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = getFormInputs(form);
            let actionUrl = form.attr('action');
            $btn = $('#update_client_btn');
            $.ajax({
                url: actionUrl,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    disableAndLoadingButton($btn, "جاري التحديث..");
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire(
                            'تهانينا !',
                            response.msg,
                            'success'
                        ).then(function () {
                            location.href = response.route;
                        })
                    }
                },
                error: function (error) {
                    enableAndLoadingButton($btn, "تحديث البيانات");
                    console.log(error.responseJSON.errors);
                    Swal.fire(
                        '  خطأ !',
                        'هناك بعض الاخطاء في البيانات  !',
                        'error'
                    ).then(function () {
                        $.each(error.responseJSON.errors, function (key, value) {
                            $('.client_register_' + key + '_error').text(value);
                        });
                    })


                }
            });

        })
    </script>

@endsection
