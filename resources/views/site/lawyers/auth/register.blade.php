@extends('site.layouts.main')
@section('title', 'التسجيل في منصة يمتاز')
@section('content')
    <style>
        .select2 {
            height: 100%;
        }
    </style>
    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">
                    <div class=" text-center mt-2 mb-3">
                        <h2>سجل بياناتك هنا</h2>
                    </div>


                    <!--Login Form-->
                    <form action="{{route('site.lawyer.save.register.data')}}" method="post"
                          enctype="multipart/form-data" id="lawyer-register-form">
                        @csrf

                        <div class="card">
                            <div class="card-header text-center">
                                <span class="card-title">الشاشة الاولى</span>
                            </div>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label> الاسم الاول</label>
                                            <input type="text" id="fname" required
                                                   class="form-control" name="fname"
                                                   placeholder="الاسم الأول" value="{{old('fname')}}">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_register_fname_error ">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label> الاسم الثاني</label>
                                            <input type="text" id="sname" required
                                                   class="form-control" name="sname"
                                                   placeholder="الاسم الثاني" value="{{old('sname')}}">

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_register_sname_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label> الاسم الثالث</label>
                                            <input type="text" name="tname" id="tname"
                                                   class="form-control"
                                                   placeholder="الاسم الثالث" value="{{old('tname')}}">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_register_tname_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label> الاسم الرابع</label>
                                            <input type="text" id="fourthname"
                                                   class="form-control" required
                                                   name="fourthname"
                                                   placeholder="الاسم الرابع"
                                                   value="{{old('fourthname')}}">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_register_fourthname_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6">
                                        <label> البريد الالكتروني </label>
                                        <input type="email" name="email" id="email" required
                                               class="form-control "
                                               placeholder="البريد الالكتروني" value="{{old('email')}}">
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_email_error"></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label> رقم الجوال :</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <select class="form-control select2" required name="phone_code" required
                                                        id="phone_code">
                                                    @foreach($countries as $country)
                                                        <option
                                                            value="{{$country->phone_code}}">{{$country->name. ' '.'('.$country->phone_code.' )'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="number" name="phone" id="phone" required
                                                   class="form-control"
                                                   minlength="12"
                                                   min="0"
                                                   pattern="[0-9]"
                                                   maxlength="9"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                   value="{{old('phone')}}">
                                        </div>

                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_phone_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6">

                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">كلمة المرور</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                            <span class="input-group-text cursor-pointer" >   <span id="togglePassword" class="adon-icon"><span class="fa fa-unlock-alt"></span></span></span>
                                        </div>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_password_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card mt-3">
                            <div class="card-header text-center">

                                <span class="card-title">الشاشة الثانية</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label> الصفة :</label>
                                            <select id="type" required
                                                    class="form-control select2"
                                                    name="type" onchange="licencesfun(event)">
                                                <option value="">-- اختر --</option>
                                                <option {{old('type') =='1' ?'selected' :''}}  value="1">فرد</option>
                                                <option {{old('type') =='2' ?'selected' :''}}  value="2">مؤسسة</option>
                                                <option {{old('type') =='3' ?'selected' :''}}  value="3">شركة</option>
                                                <option {{old('type') =='4' ?'selected' :''}} value="4">جهة حكومية
                                                </option>
                                                <option {{old('type') =='5' ?'selected' :''}}  value="5">هيئة</option>
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_type_error">
                                            </span>
                                        </div>

                                    </div>
                                    <div class="row mt-2 ">
                                        <div class="col-lg-12">
                                            <div class="form-group" id="div_cv" style="display: none;">
                                                <label> ارفاق السيرة الذاتية :</label>
                                                <input type="file" name="cv" id="cv"
                                                       class="form-control @error('cv') is-invalid  @enderror"
                                                       accept=".png ,.jpg,.jpeg ,.pdf">

                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_cv_error">
                                        </span>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group" id="div_company_lisences_no" style="display: none;">
                                                <label>رقم سجل التجاري :</label>
                                                <input type="number"
                                                       class="form-control"
                                                       name="company_lisences_no" id="company_lisences_no"
                                                       value="{{old('company_lisences_no')}}"
                                                       placeholder="رقم سجل التجاري "
                                                       maxLength="14"
                                                       pattern="[0-9]"
                                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_company_lisences_no_error">
                                            </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group" id="div_company_lisences_file"
                                                 style="display: none;">
                                                <label> نسخة من السجل التجاري :</label>
                                                <input type="file" name="company_lisences_file"
                                                       id="company_lisences_file"
                                                       class="form-control @error('company_lisences_file') is-invalid  @enderror"
                                                       accept=".png ,.jpg,.jpeg ,.pdf">

                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_company_lisences_file_error">
                                        </span>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group" id="div_company_name" style="display: none;">
                                                <label> اسم الجهة :</label>
                                                <input type="text" name="company_name" id="company_name"
                                                       class="form-control"
                                                       placeholder="اسم الجهة">
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_company_name_error">
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group">
                                        <label> تعريف مختصر :</label>
                                        <textarea id="about" name="about" required
                                                  class="form-control"
                                                  rows="3">{{old('about')}} </textarea>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_about_error">
                                            </span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label> تاريخ الميلاد :</label>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label> يوم :</label>
                                            <input type="number" name="day" required
                                                   id="day"
                                                   class="form-control"
                                                   value="{{old('day')}}" min="1" max="31"
                                                   maxlength="2"
                                                   pattern="[0-9]"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_day_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label> شهر :</label>
                                            <select class="form-control select2" name="month" id="month" required>
                                                <option value="01">كانون الثاني (يناير)</option>
                                                <option value="02">شباط (فبراير)</option>
                                                <option value="03">آذار (مارس)</option>
                                                <option value="04">نيسان (أبريل)</option>
                                                <option value="05">آيار (مايو)</option>
                                                <option value="06">حزيران (يونيو)</option>
                                                <option value="07">تموز (يوليو)</option>
                                                <option value="08">آب (أغسطس)</option>
                                                <option value="09">أيلول (سبتمبر)</option>
                                                <option value="10">تشرين الأول (أكتوبر)</option>
                                                <option value="11">تشرين الثاني (نوفمبر)</option>
                                                <option value="12">كانون الأول (ديسمبر)</option>
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_month_error">
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label> سنة :</label>
                                            <input type="number" name="year" id="year" required
                                                   class="form-control"
                                                   value="{{old('year')}}"
                                                   maxlength="4"
                                                   pattern="[0-9]"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_year_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group" style="height: 50%">
                                        <label> الجنس :</label>
                                        <select id="gender" name="gender" required
                                                class="form-control select2 ">
                                            <option value=""> -- اختر --</option>
                                            <option {{old('gender') ==='Male' ?'selected' :''}} value="Male">ذكر
                                            </option>
                                            <option {{old('gender') ==='Female' ?'selected' :''}} value="Female">أنثى
                                            </option>
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_gender_error">
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card mt-3">
                            <div class="card-header text-center">

                                <span class="card-title">الشاشة الثالثة</span>
                            </div>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label> الجنسية :</label>
                                            <select id="nationality" name="nationality" required
                                                    class="form-control select2">
                                                <option value=""> -- اختر --</option>
                                                @foreach ($countries as $item)
                                                    <option
                                                        {{old('nationality')==$item->id ?'selected':''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_nationality_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label> الدولة :</label>
                                            <select id="country_id" name="country_id" required
                                                    class="form-control select2">
                                                <option value=""> -- اختر --</option>
                                                {{GetSelectItem('countries', 'name','','status',1)}}
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_country_id_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label> المنطقة :</label>
                                            <select id="region" name="region"
                                                    class="form-control select2">
                                                @include('site.lawyers.includes.region-select')
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_region_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label> المدينة :</label>
                                            <select id="city" name="city"
                                                    class="form-control select2">
                                                @include('site.lawyers.includes.cities-select')
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_city_error">
                                    </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-2">
                                    <div class="form-group">
                                        <label for="file"> الإحداثيات </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" readOnly id="lat" name="lat" required
                                                       class="form-control"
                                                       placeholder="خط الطول">
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_lat_error"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" readOnly id="lon" name="lon" required
                                                       class="form-control"
                                                       placeholder="خط العرض">

                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_lon_error"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div style="height: 300px; width: 100%" id='map-canvas'></div>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="card mt-3">
                            <div class="card-header text-center">
                                <span class="card-title">الشاشة الرابعة</span>
                            </div>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label> نوع الهوية :</label>
                                            <select id="identity_type" required
                                                    class="form-control  select2"
                                                    name="identity_type" onchange="identityfun(event)">
                                                <option {{old('identity_type')==1 ?'selected':''}} value="1">هوية وطنيه
                                                </option>
                                                <option {{old('identity_type')==2 ?'selected':''}} value="2"> جواز السفر
                                                </option>
                                                <option {{old('identity_type')==3 ?'selected':''}} value="3"> هوية مقيم
                                                </option>
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_identity_type_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> الرقم :</label>
                                            <input type="number" name="nat_id" id="nat_id"
                                                   class="form-control "
                                                   placeholder="الرقم" value="{{old('nat_id')}}"
                                                   maxlength="10"
                                                   pattern="[0-9]"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_nat_id_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> نسخة من الهوية :</label>
                                            <input type="file" name="id_file" id="id_file"
                                                   class="form-control "
                                                   accept=".png , .pdf ,.jpeg ,.jpg">
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_id_file_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group" style="height: 50%">
                                        <label> الحالة الوظيفية :</label>
                                        <select id="functional_cases" name="functional_cases" required
                                                class="form-control select2">
                                            <option value=""> -- اختر --</option>
                                            @foreach($functional_cases as $functional_case)
                                                <option
                                                    value="{{$functional_case->id}}">{{$functional_case->title}}</option>
                                            @endforeach
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_functional_cases_error">
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mt-2" id="repeaterForm">
                                        <div class="form-group form-md-line-input mt-repeater">
                                            <div data-repeater-list="sections">
                                                <div data-repeater-item="" class="mt-repeater-item">
                                                    <div class="mt-repeater-row">
                                                        <div class="form-group m-form__group row"
                                                             style="margin-bottom: 15px;">
                                                            <div class="select col-lg-4 m-form__group-sub">
                                                                <label>المهنة</label>
                                                                <select name="sections" class="form-control section-select-input" required onchange="toggleElementsVisibility(this)">
                                                                    <option value="">-- اختر --</option>
                                                                    @foreach ($sections as $section)
                                                                        <option
                                                                            value="{{ $section->id }}"> {{$section->title}}  </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="select col-lg-3 m-form__group-sub hide-inputs"   style="display: none">
                                                                <label>الترخيص</label>
                                                                <input type="number" name="licence_no"
                                                                       placeholder="الترخيص"
                                                                       class="form-control "
                                                                       maxlength="14"
                                                                       pattern="[0-9]"
                                                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                            </div>
                                                            <div class="select col-lg-3 m-form__group-sub hide-inputs" style="display: none">
                                                                <label>ملف الترخيص</label>
                                                                <input type="file" name="licence_file"
                                                                       class="form-control"     accept=".png ,.jpg,.jpeg,.pdf">
                                                            </div>
                                                            <div class="col-md-1 dlt">
                                                                <a href="javascript:" style="margin-top: 0px;"
                                                                   data-repeater-delete=""
                                                                   class="btn btn-danger mt-repeater-delete">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_licence_no_error">
                                        </span>
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_register_licence_file_error">
                                        </span>
                                            </div>
                                            <div class="form-group m-form__group ">
                                                <a href="javascript:" data-repeater-create=""
                                                   class="btn btn-info mt-repeater-add">
                                                    <i class="fa fa-plus"></i> اضف مهنة جديدة
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-2">
                                    <div class="form-group" style="height: 50%">
                                        <label> الدرجة العلمية :</label>
                                        <select id="degree" name="degree" required
                                                class="form-control select2"
                                                onchange="sesnfun(event)">
                                            <option value=""> -- اختر --</option>
                                            {{GetSelectItem('degrees', 'title','','status',1)}}
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_degree_error">
                                        </span>
                                    </div>
                                </div>
                                <div class="row mt-2" id="div_degree_certificate_old">
                                    <div class="form-group">
                                        <label> الشهادة العلمية :</label>
                                        <input type="file" name="degree_certificate" id="degree_certificate"
                                               class="form-control @error('degree_certificate') is-invalid  @enderror"
                                               accept=".png ,.jpg,.jpeg ,.pdf">

                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_degree_certificate_error">
                                        </span>
                                    </div>
                                </div>


                                <div class="row mt-2">
                                    <div class="form-group" style="height: 50%">
                                        <label> التخصصات العامة :</label>
                                        <select id="general_specialty" name="general_specialty" required
                                                class="form-control select2">
                                            <option value=""> -- اختر --</option>
                                            @foreach($general_specialties as $general_specialty)
                                                <option
                                                    value="{{$general_specialty->id}}">{{$general_specialty->title}}</option>
                                            @endforeach
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_general_specialty_error">
                                        </span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="form-group" style="height: 50%">
                                        <label> التخصصات الدقيقة :</label>
                                        <select id="accurate_specialty" name="accurate_specialty" required
                                                class="form-control select2">
                                            <option value=""> -- اختر --</option>
                                            @foreach($accurate_specialties as $accurate_specialty)
                                                <option
                                                    value="{{$accurate_specialty->id}}">{{$accurate_specialty->title}}</option>
                                            @endforeach
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_register_accurate_specialty_error">
                                        </span>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="card mt-3">
                            <div class="card-header text-center">
                                <span class="card-title">الشاشة الخامسة</span>
                            </div>
                            <div class="card-body">
                                <div class="row mt-2 text-center">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">الصوره الشخصيه </label>
                                            <br>
                                            <label for="personal_image">
                                                <img src="{{asset('uploadimage.png')}}" width="30%" height="30%">
                                            </label>
                                            <input type="file" name="personal_image" class="form-control"
                                                   accept=".png ,.jpg,.jpeg" id="personal_image" style="display: none ;"
                                                   onchange="getImage(this.value)">
                                            <div id="display-image"></div>
                                            <br>
                                            <label for="personal_image"> يقبل فقط (png , jpeg , jpg)
                                            </label>
                                            <br>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_personal_image_error">
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> الشعار</label>
                                            <br>
                                            <label for="logo">
                                                <img src="{{asset('uploadimage.png')}}" width="30%" height="30%">
                                            </label>
                                            <input type="file" name="logo" class="form-control"
                                                   accept=".png ,.jpg,.jpeg" id="logo" style="display: none ;"
                                                   onchange="getLogo(this.value)">
                                            <div id="display-logo"></div>
                                            <br>
                                            <label for="logo">
                                                يقبل فقط (png , jpeg , jpg)
                                            </label>
                                            <br>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_register_logo_error">
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group">
                                <input type="checkbox" name="rules" id="rules" required>
                                <label for="rules">
                                    الموافقه على ميثاق الانضمام للتطبيق ؟
                                    <a target="_blank" href="{{route('site.lawyers.rules')}}">الإطلاع على
                                        البنود.</a>
                                </label>
                                <span style="display: block;text-align: right;"
                                      class="text-danger error-text lawyer_register_rules_err"></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group text-center">
                                <button type="submit" id="lawyer-register-form-btn" class="theme-btn btn-style-three register-submit"><span
                                        class="txt">سجل هنا</span>
                                </button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group submit-text pull-right">
                                لا يجوز لك استخدام، أو حث الآخرين على استخدام، أي نظام ممكن أو برنامج إلكتروني
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

    </section>

@endsection

@section('site_scripts')
    @include('site.lawyers.auth.register_js')
@endsection
