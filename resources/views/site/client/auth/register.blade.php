@extends('site.layouts.main')
@section('title', 'التسجيل في منصة يمتاز')
@section('content')

    <!-- Contact Form Section -->
    <section class="card card-body">
        <div class="form-column column col-lg-12 col-md-12 col-sm-12">

            <div class=" text-center mt-2">
                <h2>سجل بياناتك هنا</h2>
            </div>
            <!--Login Form-->
            <div class="p-5">
                <form id="client-registration" action="{{route('site.client.save.register.data')}}" method="post">
                    @csrf
                    <div class="row ">
                        <div class="col-lg-6">
                            <label for="">الاسم بالكامل</label>
                            <input type="text" name="name" value="" id="name" class="form-control"
                                   placeholder="الاسم بالكامل">
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text client_register_name_error"></span>
                        </div>
                        <div class="col-lg-6">
                            <label for=""> رقم الجوال</label>

                            <div class="input-group">
                                <div class="input-group-append">

                                    <select class="form-control select2" required name="phone_code" id="phone_code">
                                        @foreach($countries as $country)
                                            <option
                                                value="{{$country->phone_code}}">{{$country->name. ' '.'('.$country->phone_code.' )'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="number" name="mobile" id="mobile"
                                       class="form-control"
                                       minlength="9"
                                       pattern="[0-9]"
                                       min="0"
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
                                    <option value="{{$country->id}}">{{$country->name}}</option>
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
                                    @include('site.lawyers.includes.region-select')
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
                                    @include('site.lawyers.includes.cities-select')
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
                                    <option value="{{$nationality->id}}">{{$nationality->name}}</option>
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
                                <option value="Male">ذكر
                                </option>
                                <option  value="Female">أنثى
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
                                   placeholder="البريد الالكتروني">
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text client_register_email_error"></span></div>
                        <div class="col-lg-6">

                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">كلمة المرور</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                <span class="input-group-text cursor-pointer" >   <span id="togglePassword" class="adon-icon"><span class="fa fa-unlock-alt"></span></span></span>

                            </div>


                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text client_register_password_error"></span></div>
                    </div>

                    <div class="row mt-3">
                        <label for=""> الصفة</label>
                        <select class="form-control" id="type" name="type" style="height: 50px">
                            <option value="1">فرد</option>
                            <option value="2">مؤسسة</option>
                            <option value="3">شركة</option>
                            <option value="4">جهة حكومية</option>
                            <option value="5">هيئة</option>
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
                            الموافقه على ميثاق الانضمام للتطبيق ؟ <a href="{{route('site.lawyers.rules')}}">الإطلاع
                                على البنود.</a>
                        </label>
                        <span style="display: block;text-align: right;"
                              class="text-danger error-text client_register_rules_error"></span>
                    </div>

                    <div class="clearfix">
                        <div class="form-group text-center">
                            <button type="submit" class="theme-btn btn-style-three " id="save_client_btn"><span
                                    class="txt">سجل هنا</span></button>
                        </div>
                        <br>
                        <div class="form-group submit-text pull-right">
                            لا يجوز لك استخدام، أو حث الآخرين على استخدام، أي نظام مميكن أو برنامج إلكتروني لاستخراج
                            محتوى أو بيانات من موقعنا الإلكتروني باستثناء الحالات التي تدخل فيها أنت شخصياً، أو يدخل
                            فيها أي طرف ثالث معني طرفاً في اتفاق خطي معنا يُجيز هذا الفعل صراحة
                        </div>
                    </div>


                </form>
            </div>

        </div>
    </section>
@endsection

@section('site_scripts')
    @include('site.client.auth.register_js')
@endsection
