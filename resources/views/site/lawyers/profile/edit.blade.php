@extends('site.layouts.main')
@section('title', 'تحديث البيانات')
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
                        <h2>حدث بياناتك هنا</h2>
                    </div>


                    <!--Login Form-->
                    <form action="{{route('site.lawyer.update.register.data')}}" method="post"
                          enctype="multipart/form-data" id="lawyer-update-form">
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
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
                                                   placeholder="الاسم الأول" value="{{$lawyer->first_name}}">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_update_fname_error ">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label> الاسم الثاني</label>
                                            <input type="text" id="sname" required
                                                   class="form-control" name="sname"
                                                   placeholder="الاسم الثاني" value="{{$lawyer->second_name}}">

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_update_sname_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label> الاسم الثالث</label>
                                            <input type="text" name="tname" id="tname"
                                                   class="form-control"
                                                   placeholder="الاسم الثالث" value="{{$lawyer->third_name}}">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_update_tname_error">
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
                                                   value="{{$lawyer->fourth_name}}">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text lawyer_update_fourthname_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6">
                                        <label> البريد الالكتروني </label>
                                        <input type="email" name="email" id="email" required
                                               class="form-control "
                                               placeholder="البريد الالكتروني" value="{{$lawyer->email}}">
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_email_error"></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label> رقم الجوال :</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <select class="form-control select2" required name="phone_code" required
                                                        id="phone_code">
                                                    @foreach($countries as $country)
                                                        <option
                                                            value="{{$country->phone_code}}" {{$lawyer->phone_code == $country->phone_code?'selected':''}}>{{$country->name. ' '.'('.$country->phone_code.' )'}}</option>
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
                                                   value="{{str_replace($lawyer->phone_code,'',$lawyer->phone)}}">
                                        </div>

                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_phone_error"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6">

                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">كلمة المرور</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="password"
                                                   name="password" tabindex="2"
                                                   placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                   aria-describedby="login-password"/>
                                            <span class="input-group-text cursor-pointer">   <span id="togglePassword"
                                                                                                   class="adon-icon"><span
                                                        class="fa fa-unlock-alt"></span></span></span>
                                        </div>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_password_error"></span>
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
                                                <option {{$lawyer->type =='1' ?'selected' :''}}  value="1">فرد</option>
                                                <option {{$lawyer->type =='2' ?'selected' :''}}  value="2">مؤسسة
                                                </option>
                                                <option {{$lawyer->type =='3' ?'selected' :''}}  value="3">شركة</option>
                                                <option {{$lawyer->type =='4' ?'selected' :''}} value="4">جهة حكومية
                                                </option>
                                                <option {{$lawyer->type =='5' ?'selected' :''}}  value="5">هيئة</option>
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_type_error">
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
                                                @if(!is_null($lawyer->cv))
                                                    <a class="btn btn-primary" href="{{$lawyer->cv}}"
                                                       target="_blank">عرض ملف السيرة الذاتية</a>
                                                @endif

                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_update_cv_error">
                                        </span>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group" id="div_company_lisences_no" style="display: none;">
                                                <label>رقم سجل التجاري :</label>
                                                <input type="number"
                                                       class="form-control"
                                                       name="company_lisences_no" id="company_lisences_no"
                                                       placeholder="رقم سجل التجاري "
                                                       maxLength="14"
                                                       pattern="[0-9]"
                                                       value="{{$lawyer->company_lisences_no}}"
                                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_update_company_lisences_no_error">
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
                                                @if(!is_null($lawyer->company_lisences_file))
                                                    <a class="btn btn-primary" href="{{$lawyer->company_lisences_file}}"
                                                       target="_blank">عرض الملف</a>
                                                @endif
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_update_company_lisences_file_error">
                                        </span>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group" id="div_company_name" style="display: none;">
                                                <label> اسم الجهة :</label>
                                                <input type="text" name="company_name" id="company_name"
                                                       class="form-control"
                                                       placeholder="اسم الجهة" value="{{$lawyer->company_name}}">
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_update_company_name_error">
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
                                                  rows="3"> {{$lawyer->about}} </textarea>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_about_error">
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
                                                   value="{{$lawyer->day}}" min="1" max="31"
                                                   maxlength="2"
                                                   pattern="[0-9]"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_day_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label> شهر :</label>
                                            <select class="form-control select2" name="month" id="month" required>
                                                <option {{$lawyer->day === '01' ?'selected':''}} value="01">كانون الثاني
                                                    (يناير)
                                                </option>
                                                <option {{$lawyer->day === '02' ?'selected':''}}   value="02">شباط
                                                    (فبراير)
                                                </option>
                                                <option {{$lawyer->day === '03' ?'selected':''}}  value="03">آذار
                                                    (مارس)
                                                </option>
                                                <option {{$lawyer->day === '04' ?'selected':''}}   value="04">نيسان
                                                    (أبريل)
                                                </option>
                                                <option {{$lawyer->day === '05' ?'selected':''}}  value="05">آيار
                                                    (مايو)
                                                </option>
                                                <option {{$lawyer->day === '06' ?'selected':''}}   value="06">حزيران
                                                    (يونيو)
                                                </option>
                                                <option {{$lawyer->day === '07' ?'selected':''}}   value="07">تموز
                                                    (يوليو)
                                                </option>
                                                <option {{$lawyer->day === '08' ?'selected':''}}  value="08">آب
                                                    (أغسطس)
                                                </option>
                                                <option {{$lawyer->day === '09' ?'selected':''}}   value="09">أيلول
                                                    (سبتمبر)
                                                </option>
                                                <option {{$lawyer->day === '10' ?'selected':''}}  value="10">تشرين الأول
                                                    (أكتوبر)
                                                </option>
                                                <option {{$lawyer->day === '11' ?'selected':''}}  value="11">تشرين
                                                    الثاني (نوفمبر)
                                                </option>
                                                <option {{$lawyer->day === '12' ?'selected':''}}   value="12">كانون
                                                    الأول (ديسمبر)
                                                </option>
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_month_error">
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label> سنة :</label>
                                            <input type="number" name="year" id="year" required
                                                   class="form-control"
                                                   value="{{$lawyer->year}}"
                                                   maxlength="4"
                                                   pattern="[0-9]"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_year_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="form-group" style="height: 50%">
                                        <label> الجنس :</label>
                                        <select id="gender" name="gender" required
                                                class="form-control select2 ">
                                            <option value="">-- اختر --</option>
                                            <option {{$lawyer->gender ==='Male' ?'selected' :''}} value="Male">ذكر
                                            </option>
                                            <option {{$lawyer->gender ==='Female' ?'selected' :''}} value="Female">أنثى
                                            </option>
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_gender_error">
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
                                                        {{$lawyer->nationality ==$item->id ?'selected':''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_nationality_error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label> الدولة :</label>
                                            <select id="country_id" name="country_id" required
                                                    class="form-control select2">
                                                <option value=""> -- اختر --</option>
                                                @foreach($countries as $country)
                                                    <option
                                                        value="{{$country->id}}" {{$lawyer->country_id == $country->id?'selected':''}}>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_country_id_error">
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
                                                  class="text-danger error-text lawyer_update_region_error">
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
                                                  class="text-danger error-text  lawyer_update_city_error">
                                    </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-2">
                                    <div class="form-group">
                                        <label for="file"> الإحداثيات </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" readOnly id="lat" name="lat"
                                                       class="form-control" value="{{$lawyer->latitude}}"
                                                       placeholder="خط الطول">
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_update_lat_error"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" readOnly id="lon" name="lon"
                                                       class="form-control"
                                                       placeholder="خط العرض" value="{{$lawyer->longitude}}">

                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_update_lon_error"></span>
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
                                                <option {{$lawyer->identity_type==1 ?'selected':''}}  value="1">هوية
                                                    وطنيه
                                                </option>
                                                <option {{$lawyer->identity_type==2 ?'selected':''}}  value="2"> جواز
                                                    السفر
                                                </option>
                                                <option {{$lawyer->identity_type==3 ?'selected':''}}  value="3"> هوية
                                                    مقيم
                                                </option>
                                            </select>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_identity_type_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> الرقم :</label>
                                            <input type="text" name="nat_id" id="nat_id"
                                                   class="form-control "
                                                   placeholder="الرقم"
                                                   value="{{$lawyer->nat_id}}"
                                                   maxlength="10"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_nat_id_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> نسخة من الهوية :</label>
                                            <input type="file" name="id_file" id="id_file"
                                                   class="form-control "
                                                   accept=".png , .pdf ,.jpeg ,.jpg">
                                            @if(!is_null($lawyer->id_file))
                                                <a class="btn btn-primary" href="{{$lawyer->id_file}}"
                                                   target="_blank">عرض الملف</a>
                                            @endif
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_id_file_error"></span>
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
                                                    value="{{$functional_case->id}}" {{$lawyer->functional_cases == $functional_case->id ?'selected':''}} >{{$functional_case->title}}</option>
                                            @endforeach
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_functional_cases_error">
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table text-center " id="LawyerSectionsTable">
                                        <thead>
                                        <tr>
                                            <th scope="col">المهنة</th>
                                            <th scope="col">المهنة تحتاج ترخيص</th>
                                            <th scope="col">رقم الترخيص</th>
                                            <th scope="col">ملف الترخيص</th>
                                            <th scope="col">عمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($lawyer_sections as $section)
                                            <tr>
                                                <td>{{\App\Models\DigitalGuide\DigitalGuideCategories::where('id',$section->section_id)->first()->title}}</td>
                                                @if(\App\Models\DigitalGuide\DigitalGuideCategories::where('id',$section->section_id)->first()->need_license == 1)
                                                    <td>تحتاج ترخيص</td>
                                                @else
                                                    <td> لا تحتاج ترخيص</td>
                                                @endif
                                                <td>{{$section->licence_no}}</td>
                                                <td>
                                                    @if(!is_null($section->licence_file))
                                                        <a class="btn btn-primary"
                                                           href="{{$section->licence_file}}"
                                                           target="_blank">عرض الملف</a>
                                                    @endif

                                                </td>
                                                <td>
                                                    <a class="btn-delete-lawyer-section m-1"
                                                       id="btn_delete_lawyer_section_{{$section->id}}"
                                                       href="{{route('admin.digital-guide.delete.section', $section->id)}}"
                                                       data-id="{{$section->id}}" title="حذف ">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a class="btn-edit-lawyer-section m-1"
                                                       id="btn_edit_lawyer_section_{{$section->id}}"
                                                       href="{{route('admin.digital-guide.edit.section', $section->id)}}"
                                                       data-id="{{$section->id}}" title="تعديل ">
                                                        <i class="fa-solid fa-user-pen"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-2" id="repeaterForm">
                                        <div class="form-group form-md-line-input mt-repeater">
                                            <div data-repeater-list="sections">
                                                <div data-repeater-item="" class="mt-repeater-item">
                                                    <div class="mt-repeater-row">
                                                        <div class="form-group m-form__group row"
                                                             style="margin-bottom: 15px;">
                                                            <div class="select col-lg-4 m-form__group-sub">
                                                                <label>المهنة</label>
                                                                <select name="sections"
                                                                        class="form-control section-select-input"
                                                                        onchange="toggleElementsVisibility(this)">
                                                                    <option value="">-- اختر --</option>
                                                                    @foreach ($sections as $section)
                                                                        <option
                                                                            value="{{ $section->id }}"> {{$section->title}}  </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="select col-lg-3 m-form__group-sub hide-inputs"
                                                                 style="display: none">
                                                                <label>الترخيص</label>
                                                                <input type="number" name="licence_no"
                                                                       placeholder="الترخيص"
                                                                       class="form-control "
                                                                       maxlength="14"
                                                                       pattern="[0-9]"
                                                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                            </div>
                                                            <div class="select col-lg-3 m-form__group-sub hide-inputs"
                                                                 style="display: none">
                                                                <label>ملف الترخيص</label>
                                                                <input type="file" name="licence_file"
                                                                       class="form-control"
                                                                       accept=".png ,.jpg,.jpeg,.pdf">
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
                                                      class="text-danger error-text lawyer_update_licence_no_error"></span>
                                                <span style="text-align: right;"
                                                      class="text-danger error-text lawyer_update_licence_file_error"></span>
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
                                            @foreach($degrees as $degree)
                                                <option
                                                    value="{{$degree->id}}" {{$lawyer->degree == $degree->id ?'selected':''}}> {{$degree->title}}</option>
                                            @endforeach
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_degree_error">
                                        </span>
                                    </div>
                                </div>
                                <div class="row mt-2" id="div_degree_certificate_old">
                                    <div class="form-group">
                                        <label> الشهادة العلمية :</label>
                                        <input type="file" name="degree_certificate" id="degree_certificate"
                                               class="form-control @error('degree_certificate') is-invalid  @enderror"
                                               accept=".png ,.jpg,.jpeg ,.pdf">
                                        @if(!is_null($lawyer->degree_certificate))
                                            <a class="btn btn-primary" href="{{$lawyer->degree_certificate}}"
                                               target="_blank">عرض الشهادة</a>
                                        @endif
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_degree_certificate_error">
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
                                                    value="{{$general_specialty->id}}" {{$lawyer->general_specialty == $general_specialty->id ?'selected':''}} >{{$general_specialty->title}}</option>
                                            @endforeach
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_general_specialty_error">
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
                                                    value="{{$accurate_specialty->id}}" {{$lawyer->accurate_specialty == $accurate_specialty->id ?'selected':''}}>{{$accurate_specialty->title}}</option>
                                            @endforeach
                                        </select>
                                        <span style="text-align: right;"
                                              class="text-danger error-text lawyer_update_accurate_specialty_error">
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

                                            <label for="">
                                                <img src="{{$lawyer->photo}}" width="30%" height="30%">
                                            </label>

                                            <input type="file" name="personal_image" class="form-control"
                                                   accept=".png ,.jpg,.jpeg" id="personal_image"
                                                   onchange="getImage(this.value)">
                                            <div id="display-image"></div>
                                            <br>
                                            <label for="personal_image"> يقبل فقط (png , jpeg , jpg)
                                            </label>
                                            <br>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_personal_image_error">
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for=""> الشعار</label>
                                            <br>
                                            <label for="">
                                                <img src="{{$lawyer->logo}}" width="30%" height="30%">
                                            </label>
                                            <input type="file" name="logo" class="form-control"
                                                   accept=".png ,.jpg,.jpeg" id="logo"
                                                   onchange="getLogo(this.value)">
                                            <div id="display-logo"></div>
                                            <br>
                                            <label for="logo">
                                                يقبل فقط (png , jpeg , jpg)
                                            </label>
                                            <br>
                                            <span style="text-align: right;"
                                                  class="text-danger error-text lawyer_update_logo_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="form-group text-center">
                                <button type="submit" id="lawyer-update-form-btn"
                                        class="theme-btn btn-style-three update-submit"><span
                                        class="txt">تحديث البيانات</span>
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
    <div class="modal fade text-start" id="edit_section_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h4 class="modal-title" id="myModalLabel33">تعديل بيانات الترخيص </h4>
                    <button type="button" class="btn-close text-left" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="{{route('admin.digital-guide.update.section')}}" class="text-right" method="post" id="edit_section_form">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body form-group">
                        <label>المهنة</label>
                            <select name="sections" id="update_section_select_input"
                                    class="form-control section-select-input"
                                    onchange="toggleElementsVisibilityUpdateSection(this)">
                                <option value="">-- اختر --</option>
                                @foreach ($sections as $section)
                                    <option
                                        value="{{ $section->id }}"> {{$section->title}}  </option>
                                @endforeach
                            </select>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="select update-section-hide-inputs"
                                     style="display: none">
                                    <label>الترخيص</label>
                                    <input type="number" name="licence_no"
                                           id="licence_no"
                                           placeholder="الترخيص"
                                           class="form-control "
                                           maxlength="14"
                                           pattern="[0-9]"
                                           oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="select update-section-hide-inputs"
                                     style="display: none">
                                    <label>ملف الترخيص</label>
                                    <input type="file" name="licence_file"
                                           class="form-control"
                                           accept=".png ,.jpg,.jpeg,.pdf">
                                    <a class="btn btn-primary" id="licence_file_a" style="display: none"
                                       target="_blank">عرض الملف</a>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('site_scripts')
    @include('site.lawyers.profile.edit_js')
@endsection
