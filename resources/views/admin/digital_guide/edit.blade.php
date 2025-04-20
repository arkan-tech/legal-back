@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            @if(Session::has('error-sections'))
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading"> خطأ في البيانات</h4>
                    <div class="alert-body">
                        <div class="">
                            <ul>
                                <li>{{Session::get('error-sections')}}</li>
                            </ul>
                        </div>
                    </div>

                </div>
            @endif
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.digital-guide.updateDigitalGuide')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">الشاشة الاولى </h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <input type="hidden" name="id" value="{{$lawyer->id}}">

                                    <div class="row mt-3">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label> الاسم الاول</label>
                                                <input type="text" id="fname"
                                                       class="form-control @error('fname')is-invalid @enderror"
                                                       name="fname"
                                                       placeholder="الاسم الأول" value="{{$lawyer->first_name}}">
                                                @error('fname')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label> الاسم الثاني</label>
                                                <input type="text" id="sname"
                                                       class="form-control  @error('sname')is-invalid @enderror"
                                                       name="sname"
                                                       placeholder="الاسم الثاني" value="{{$lawyer->second_name}}">

                                                @error('sname')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label> الاسم الثالث</label>
                                                <input type="text" name="tname" id="tname"
                                                       class="form-control  @error('tname')is-invalid @enderror"
                                                       placeholder="الاسم الثالث" value="{{$lawyer->third_name}}">
                                                @error('tname')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <label> الاسم الرابع</label>
                                                <input type="text" id="fourthname"
                                                       class="form-control  @error('fourthname')is-invalid @enderror"
                                                       name="fourthname"
                                                       placeholder="الاسم الرابع"
                                                       value="{{$lawyer->fourth_name}}">
                                                @error('fourthname')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label for=""> رقم الجوال</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <select class="form-control select2" required name="phone_code" id="phone_code">
                                                        @foreach($countries as $country)
                                                            <option
                                                                value="{{$country->phone_code}}" {{$country->phone_code == $lawyer->phone_code ?'selected':''}}>{{$country->name. ' '.'('.$country->phone_code.' )'}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="number" name="phone" id="phone"
                                                       class="form-control"
                                                       minlength="14"
                                                       pattern="[0-9]"
                                                       min="0"
                                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                       maxlength="9"
                                                       value="{{str_replace($lawyer->phone_code,'',$lawyer->phone)}}">
                                            </div>
                                            @error('phone')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> البريد الالكتروني </label>
                                            <input type="email" name="email" id="email"
                                                   class="form-control @error('email') is-invalid @enderror "
                                                   placeholder="البريد الالكتروني" value="{{$lawyer->email}}">
                                            @error('email')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> كلمة المرور </label>
                                            <input type="text" name="password" id="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="كلمة المرور">
                                            @error('password')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">الشاشة الثانية </h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">

                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountEmail"> الصفة</label>
                                            <select
                                                class="form-control @error('type') is-invalid @enderror select2"
                                                name="type" id="type_select">
                                                <option {{$lawyer->type =='1' ?'selected' :''}}  value="1">فرد</option>
                                                <option {{$lawyer->type =='2' ?'selected' :''}}  value="2">مؤسسة
                                                </option>
                                                <option {{$lawyer->type =='3' ?'selected' :''}}  value="3">شركة</option>
                                                <option {{$lawyer->type =='4' ?'selected' :''}} value="4">جهة حكومية
                                                </option>
                                                <option {{$lawyer->type =='5' ?'selected' :''}}  value="5">هيئة</option>
                                            </select>
                                            @error('type')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1" id="cv_div" style="display: none;">
                                            <label> ملف السيرة الذاتية :</label>

                                            <input type="file" name="cv" id="cv_input"  accept=".png ,.jpg ,.jpeg ,.PNG ,.JPG, .JPEG, .pdf"
                                                   class="form-control @error('cv') is-invalid  @enderror">
                                            @if(!is_null($lawyer->cv))
                                                <a class="btn btn-primary" href="{{$lawyer->cv}}"
                                                   target="_blank">عرض ملف السيرة الذاتية</a>
                                            @endif
                                            @error('cv')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1" id="company_lisences_no_div" style="display: none;">
                                            <label> رقم التجاري :</label>
                                            <input type="number"
                                                   class="form-control"
                                                   pattern="[0-9]"
                                                   maxLength="14"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                   name="company_lisences_no"
                                                   id="company_lisences_no"
                                                   value="{{$lawyer->company_lisences_no}}"
                                                   placeholder="رقم التجاري">
                                            @error('company_lisences_no')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>



                                        <div class="col-12 col-sm-6 mb-1" id="company_lisences_file_div" style="display: none;">
                                            <label> ملف الترخيص :</label>

                                            <input type="file" name="company_lisences_file" id="company_lisences_file"
                                                   class="form-control @error('company_lisences_file') is-invalid  @enderror"
                                                   accept=".png ,.jpg ,.jpeg ,.PNG ,.JPG, .JPEG, .pdf">
                                            @if(!is_null($lawyer->company_lisences_file))
                                                <a class="btn btn-primary" href="{{$lawyer->company_lisences_file}}"
                                                   target="_blank">عرض الملف</a>
                                            @endif
                                            @error('company_lisences_file')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1" id="company_name_div"
                                             style="display: none;">
                                            <label> اسم ومعلومات الجهة :</label>
                                            <input type="text" name="company_name" id="company_name"
                                                   class="form-control"
                                                   placeholder="اسم ومعلومات الجهة"
                                                   value="{{$lawyer->company_name}}">

                                            @error('company_name')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountEmail">تعريف مختصر :</label>
                                            <textarea class="form-control @error('about')is-invalid @enderror"
                                                      name="about" rows="5">
                                                {{$lawyer->about}}
                                            </textarea>
                                            @error('about')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">تاريخ الميلاد</label>
                                            <input type="date"
                                                   class="form-control @error('birth_date')is-invalid @enderror"
                                                   name="birth_date"
                                                   value="{{$lawyer->birthday}}"/>
                                            @error('birth_date')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail"> الجنس</label>
                                            <select name="gender"
                                                    class="form-control @error('gender')is-invalid @enderror select2">
                                                <option value=""> اختر</option>
                                                <option value="Male" {{$lawyer->gender =='Male' ?'selected':''}}>ذكر
                                                </option>
                                                <option value="Female" {{$lawyer->gender =='Female' ?'selected':''}}>
                                                    انثى
                                                </option>
                                            </select>
                                            @error('gender')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">الشاشة الثالثة</h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">الجنسية </label>
                                            <select
                                                class="form-control @error('nationality')is-invalid @enderror select2"
                                                id="nationality_select" name="nationality">
                                                <option value=""> اختر</option>
                                                @include('admin.digital_guide.includes.edit.nationality-select')
                                            </select>
                                            @error('nationality')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">الدولة</label>
                                            <select
                                                name="country_id"
                                                class="form-control @error('country_id')is-invalid @enderror select2"
                                                id="country_id_select">
                                                <option value=""> اختر</option>
                                                @include('admin.digital_guide.includes.edit.countries-select')
                                            </select>
                                            @error('country_id')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">المنطقة </label>
                                            <select class="form-control @error('region')is-invalid @enderror select2"
                                                    name="region" id="region_id_select">
                                                <option value=""> اختر</option>
                                                @include('admin.digital_guide.includes.edit.region-select')
                                            </select>
                                            @error('region')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">المدينة </label>
                                            <select class="form-control @error('city') is-invalid @enderror select2"
                                                    name="city" id="city_id_select">
                                                <option value=""> اختر</option>
                                                @include('admin.digital_guide.includes.edit.cities-select')
                                            </select>
                                            @error('city')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> خط الطول :</label>
                                            <input type="text" readOnly id="lat" name="lat"
                                                   class="form-control" placeholder="خط الطول" value="{{$lawyer->latitude}}">
                                            @error('lat')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> خط العرض :</label>
                                            <input type="text" readOnly id="lon" name="lon"
                                                   class="form-control"
                                                   placeholder="خط العرض" value="{{$lawyer->longitude}}">
                                            @error('lon')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div style="height: 300px; width: 100%" id='map-canvas'></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">الشاشة الرابعة</h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">نوع الهوية</label>
                                            <select
                                                class="form-control @error('identity_type') is-invalid @enderror select2"
                                                name="identity_type" id="identity_type_select">
                                                <option value="">نوع الهوية</option>
                                                <option {{$lawyer->identity_type==1 ?'selected':''}} value="1">هوية
                                                    وطنية
                                                </option>
                                                <option {{$lawyer->identity_type==2 ?'selected':''}} value="2"> جواز
                                                    السفر
                                                </option>
                                                <option {{$lawyer->identity_type==3 ?'selected':''}} value="3"> هوية
                                                    مقيم
                                                </option>

                                            </select>
                                            @error('identity_type')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1" id="nat_id_dev">
                                            <label> الرقم :</label>
                                            <input type="{{$lawyer->identity_type ==2 ?'text':'number'}}" name="nat_id"
                                                   id="nat_id"
                                                   class="form-control "
                                                   maxlength="10"
                                                   pattern="[0-9]"
                                                   oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                   placeholder="رقم الهوية" value="{{$lawyer->nat_id}}">
                                            @error('nat_id')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1"
                                             id="other_idetity_type_dev">
                                            <label> ملف الهوية :</label>
                                            <input type="file" name="id_file" id="id_file"
                                                   class="form-control @error('id_file') is-invalid  @enderror"
                                                   accept=".png ,.jpg ,.jpeg ,.PNG ,.JPG, .JPEG, .pdf">

                                            @if(!is_null($lawyer->id_file))
                                                <a class="btn btn-primary" href="{{$lawyer->id_file}}"
                                                   target="_blank">عرض الملف</a>
                                            @endif

                                            @error('id_file')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">التخصص العام </label>
                                            <select class="form-control @error('general_specialty')is-invalid @enderror select2"
                                                id="general_specialty_select" name="general_specialty">
                                                <option value=""> اختر</option>
                                                @foreach($GeneralSpecialty as $item)
                                                    <option
                                                        value="{{$item->id}}" {{$lawyer->general_specialty == $item->id ?'selected':''}} > {{$item->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('general_specialty')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">التخصص الدقيق </label>
                                            <select
                                                name="accurate_specialty"
                                                class="form-control @error('accurate_specialty')is-invalid @enderror select2"
                                                id="accurate_specialty_select">
                                                <option value=""> اختر</option>
                                                @foreach($AccurateSpecialty as $item)
                                                    <option
                                                        value="{{$item->id}}" {{$lawyer->accurate_specialty == $item->id ?'selected':''}} > {{$item->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('accurate_specialty')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail"> الحالة الوظيفية </label>
                                            <select
                                                name="functional_cases"
                                                class="form-control @error('functional_cases')is-invalid @enderror select2"
                                                id="functional_cases_select">
                                                <option value=""> اختر</option>
                                                @foreach($functional_cases as $item)
                                                    <option
                                                        value="{{$item->id}}" {{$lawyer->functional_cases == $item->id ?'selected':''}} > {{$item->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('accurate_specialty')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail"> الدرجة العلمية</label>
                                            <select class="form-control @error('degree') is-invalid @enderror select2"
                                                    name="degree"
                                                    id="degree_select">
                                                <option value="">
                                                    الدرجة العلمية
                                                </option>
                                                @foreach($degrees as $degree)
                                                    <option value="{{$degree->id}}" {{$lawyer->degree == $degree->id ?'selected':''}}> {{$degree->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('degree')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1 ">
                                            <label class="mb-1"> الشهادة العلمية </label>
                                            <div class="">
                                                @if(!is_null($lawyer->degree_certificate))
                                                    @php
                                                        $file_extention = getFileExtention($lawyer->degree_certificate);
                                                    @endphp
                                                    @if($file_extention != 'pdf' )
                                                        <img src="{{$lawyer->degree_certificate}}"
                                                             id="account-upload-logo" class="uploadedLogo rounded me-50"
                                                             alt="profile image" height="100" width="100"/>
                                                    @else
                                                        <iframe id="account-upload-LicenseFile"
                                                                style="border:1px solid #666CCC"
                                                                title="PDF in an i-Frame"
                                                                src="{{$lawyer->degree_certificate}}"
                                                                height="300" width="300"
                                                                class="uploadedLicenseFile rounded me-50">

                                                        </iframe>
                                                    @endif

                                                @else
                                                    <img src="{{asset('uploadimage.png')}}"
                                                         id="account-upload-LicenseFile"
                                                         class="uploadedLicenseFile rounded me-50"
                                                         alt="profile image" height="300" width="300"/>
                                                @endif

                                                <!-- upload and reset button -->
                                                <div class="mt-75 ">
                                                    <div>
                                                        <label for="degree_certificate-upload"
                                                               class="btn btn-sm btn-primary mb-75 me-75">رفع</label>
                                                        <input type="file" id="degree_certificate-upload" hidden
                                                               accept=".png ,.jpg ,.jpeg ,.PNG ,.JPG, .JPEG, .pdf"
                                                               name="degree_certificate"/>
                                                        <button type="button" id="degree_certificate-reset"
                                                                class="btn btn-sm btn-outline-secondary mb-75">ازالة
                                                        </button>
                                                        <a href="{{$lawyer->degree_certificate}}"
                                                           download="{{$lawyer->name.'_degree_certificate'}}"
                                                           class="btn btn-sm btn-outline-secondary mb-75">تنزيل
                                                        </a>
                                                        <p class="mb-0">يسمح فقط بنوع : .pdf ,.png,.jpeg.</p>
                                                    </div>
                                                </div>
                                                <!--/ upload and reset button -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="card-body py-2 my-25 ">
                                            <div class="row mt-1">
                                                <div class="col-12 col-sm-12 mb-1 repeater-sections">
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
                                                                <td>{{!is_null($section->section) ?$section->section->title:'غير معروف'}}</td>
                                                                @if(!is_null($section->section) &&$section->section->section ==1 )
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
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                    <hr class="mt-3">
                                                    <div data-repeater-list="sections" class=" form-group mt-3" id="repeaterForm">
                                                        <div data-repeater-item >
                                                            <div class="row d-flex align-items-end">
                                                                <div class=" col-md-5 col-12">
                                                                    <div class="mb-1">
                                                                        <label>المهنة</label>
                                                                        <select name="sections"  onchange="toggleElementsVisibility(this)"
                                                                                class="form-control select2">
                                                                            <option
                                                                                value="">-- اختر --
                                                                            </option>
                                                                            @foreach ($sections as $section)
                                                                                <option
                                                                                    value="{{ $section->id }}"> {{$section->title}}  </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12 hide-inputs"   style="display: none">
                                                                    <div class="mb-1">
                                                                        <label>الترخيص</label>
                                                                        <input type="number" name="licence_no"
                                                                               placeholder="الترخيص"
                                                                               class="form-control "
                                                                               maxlength="14"
                                                                               pattern="[0-9]"
                                                                               oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 col-12 hide-inputs"   style="display: none">
                                                                    <div class="mb-1">
                                                                        <label>ملف الترخيص</label>
                                                                        <input type="file" name="licence_file"
                                                                               placeholder="الترخيص"
                                                                               class="form-control "
                                                                               accept=".png ,.jpg ,.jpeg ,.PNG ,.JPG, .JPEG, .pdf">
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-1 col-12 mb-50">
                                                                    <div class="mb-1">
                                                                        <button
                                                                            class="btn btn-outline-danger text-nowrap px-1"
                                                                            data-repeater-delete type="button">
                                                                            <i data-feather="x" class="me-25"></i>
                                                                            <span>ازالة</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr/>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button class="btn btn-icon btn-primary" type="button"
                                                                    data-repeater-create>
                                                                <i data-feather="plus" class="me-25"></i>
                                                                <span>اضافة مهنة </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> الشاشة الخامسة</h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="mb-1"> الشعار </label>
                                            <div class="">
                                                <img src="{{$lawyer->logo}}"
                                                     id="account-upload-logo" class="uploadedLogo rounded me-50"
                                                     alt="profile image" height="300" width="300"/>
                                                <!-- upload and reset button -->
                                                <div class="mt-75 ">
                                                    <div>
                                                        <label for="account-upload-logo-btn"
                                                               class="btn btn-sm btn-primary mb-75 me-75">رفع</label>

                                                        <input type="file" id="account-upload-logo-btn" hidden
                                                               accept="image/png, image/jpeg,image/jpg" name="logo"/>

                                                        <button type="button" id="account-reset-logo-btn"
                                                                class="btn btn-sm btn-outline-secondary mb-75">ازالة
                                                        </button>
                                                        <a href="{{$lawyer->logo}}" download="{{$lawyer->name.'_logo'}}"
                                                           class="btn btn-sm btn-outline-secondary mb-75">تنزيل الشعار
                                                        </a>
                                                        <p class="mb-0">يسمح فقط بنوع : png, jpg, jpeg.</p>
                                                    </div>
                                                </div>
                                                <!--/ upload and reset button -->
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="mb-1"> الصورة الشخصية</label>
                                            <div class="">
                                                <img src="{{$lawyer->photo}}"
                                                     id="account-upload-img" class="uploadedLogo rounded me-50"
                                                     alt="profile image" height="300" width="300"/>
                                                <!-- upload and reset button -->
                                                <div class="mt-75 ">
                                                    <div>
                                                        <label for="account-upload-img-btn"
                                                               class="btn btn-sm btn-primary mb-75 me-75">رفع</label>

                                                        <input type="file" id="account-upload-img-btn" hidden
                                                               accept=".png ,.jpg ,.jpeg ,.PNG ,.JPG, .JPEG" name="photo"/>

                                                        <button type="button" id="account-reset-img"
                                                                class="btn btn-sm btn-outline-secondary mb-75">ازالة
                                                        </button>
                                                        <a href="{{$lawyer->photo}}"
                                                           download="{{$lawyer->name.'_photo'}}"
                                                           class="btn btn-sm btn-outline-secondary mb-75">تنزيل الصورة
                                                            الشخصية
                                                        </a>
                                                        <p class="mb-0">يسمح فقط بنوع : png, jpg, jpeg.</p>
                                                    </div>
                                                </div>
                                                <!--/ upload and reset button -->
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> معلومات تتعلق في هيئة المستشارين</h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> مضاف الى هيئة المستشارين :</label>
                                            <select name="is_advisor"
                                                    id="is_advisor_select"
                                                    class="form-control @error('is_advisor') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$lawyer->is_advisor == 1?'selected':''}}>نعم
                                                </option>
                                                <option value="0" {{$lawyer->is_advisor == 0?'selected':''}}>لا</option>
                                            </select>
                                            @error('is_advisor')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1" style="display: none" id="advisor_cat_id_div">
                                            <label for="advisor_cat_id_select"> الهيئات الاستشارية </label>
                                            <select name="advisor_cat_id[]"
                                                    id="advisor_cat_id_select" multiple
                                                    class=" form-control @error('advisor_cat_id') is-invalid @enderror select2">
                                                @foreach($advisories  as $advisory)
                                                    <option
                                                        value="{{$advisory->id}}" {{in_array($advisory->id,$lawyer_advisories) ?'selected':''}}> {{$advisory->title}}  </option>
                                                @endforeach
                                            </select>
                                            @error('advisor_cat_id')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> الظهور في المستشارين المنضمين حديثا في الموقع :</label>
                                            <select name="show_in_advoisory_website"
                                                    id="show_in_advoisory_website"
                                                    class="form-control @error('show_in_advoisory_website') is-invalid @enderror  select2">
                                                <option
                                                    value="1" {{$lawyer->show_in_advoisory_website == 1?'selected':''}}>
                                                    ظاهر
                                                </option>
                                                <option
                                                    value="0" {{$lawyer->show_in_advoisory_website == 0?'selected':''}}>
                                                    مخفي
                                                </option>
                                            </select>
                                            @error('show_in_advoisory_website')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> حالة الحساب</h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> حالة القبول :</label>

                                            <select name="accepted"
                                                    id="accepted_select"
                                                    class="form-control @error('accepted') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$lawyer->accepted == 1?'selected':''}}>جديد</option>
                                                <option value="2" {{$lawyer->accepted == 2?'selected':''}}>قبول</option>
                                                <option value="3" {{$lawyer->accepted == 3?'selected':''}}>انتظار
                                                </option>
                                                <option value="0" {{$lawyer->accepted == 0?'selected':''}}>حظر</option>
                                            </select>
                                            @error('accepted')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">

                                            <label> حالة الدفع :</label>
                                            <select name="paid_status"
                                                    id="paid_status_select"
                                                    class="form-control @error('paid_status') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$lawyer->paid_status == 1?'selected':''}}>مدفوع
                                                </option>
                                                <option value="0" {{$lawyer->paid_status == 0?'selected':''}}>غير
                                                    مدفوع
                                                </option>
                                            </select>
                                            @error('paid_status')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> معلومات طلب مكتب</h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1 ">
                                            <label> طلب المكتب :</label>
                                            <select disabled
                                                    id="office_request"
                                                    class="form-control @error('office_request') is-invalid @enderror select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$lawyer->office_request == 1?'selected':''}}>
                                                    تم الطلب
                                                </option>
                                                <option value="0" {{$lawyer->office_request == 0?'selected':''}}>
                                                    لم يتم الطلب
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1 ">
                                            <label> حالة قبول طلب المكتب :</label>
                                            <select name="office_request_status"
                                                    id="office_request_status_select"
                                                    class="form-control @error('office_request_status') is-invalid @enderror select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$lawyer->office_request_status == 1?'selected':''}}>
                                                    قبول
                                                </option>
                                                <option value="0" {{$lawyer->office_request_status == 0?'selected':''}}>
                                                    رفض
                                                </option>
                                            </select>
                                            @error('office_request_status')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> طلب مكتب من تاريخ :</label>
                                            <input type="date" value="{{$lawyer->office_request_from}}"
                                                   name="office_request_from"
                                                   class="form-control @error('office_request_from') is-invalid @enderror">
                                            @error('office_request_from')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> طلب مكتب الى تاريخ :</label>
                                            <input type="date" value="{{$lawyer->office_request_to}}"
                                                   name="office_request_to"
                                                   class="form-control @error('office_request_to') is-invalid @enderror">
                                            @error('office_request_to')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> معلومات الدليل الرقمي </h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> حالة الاشتراك في باقة احد باقات الدليل الرقمي :</label>
                                            <select name="digital_guide_subscription"
                                                    id="digital_guide_subscription_select"
                                                    class="form-control @error('digital_guide_subscription') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option
                                                    value="1" {{$lawyer->digital_guide_subscription == 1?'selected':''}}>
                                                    مشترك
                                                </option>
                                                <option
                                                    value="0" {{$lawyer->digital_guide_subscription == 0?'selected':''}}>
                                                    غير مشترك
                                                </option>
                                            </select>
                                            @error('digital_guide_subscription')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> حالة الدفع للاشتراك :</label>
                                            <select name="digital_guide_subscription_payment_status"
                                                    id="digital_guide_subscription_payment_status_select"
                                                    class="form-control @error('digital_guide_subscription_payment_status') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option
                                                    value="1" {{$lawyer->digital_guide_subscription_payment_status == 1?'selected':''}}>
                                                    مدفوع
                                                </option>
                                                <option
                                                    value="0" {{$lawyer->digital_guide_subscription_payment_status == 0?'selected':''}}>
                                                    غير مدفوع
                                                </option>
                                            </select>
                                            @error('digital_guide_subscription_payment_status')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> حالة الظهور في الدليل الرقمي :</label>
                                            <select name="show_at_digital_guide"
                                                    id="show_at_digital_guide_select"
                                                    class="form-control @error('show_at_digital_guide') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$lawyer->show_at_digital_guide == 1?'selected':''}}>
                                                    ظاهر
                                                </option>
                                                <option value="0" {{$lawyer->show_at_digital_guide == 0?'selected':''}}>
                                                    مخفي
                                                </option>
                                            </select>
                                            @error('show_at_digital_guide')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> هل العضو مميز ؟ :</label>
                                            <select name="special"
                                                    id="special_select"
                                                    class="form-control @error('special') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$lawyer->special == 1?'selected':''}}>مميز</option>
                                                <option value="0" {{$lawyer->special == 0?'selected':''}}> غير مميز
                                                </option>
                                            </select>
                                            @error('special')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-1 d-none" id="digital_guide_subscription_from_to_div">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> من تاريخ :</label>
                                            <input type="date" value="{{$lawyer->digital_guide_subscription_from}}"
                                                   name="digital_guide_subscription_from"
                                                   class="form-control @error('digital_guide_subscription_from') is-invalid @enderror">
                                            @error('digital_guide_subscription_from')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> الى تاريخ :</label>
                                            <input type="date" value="{{$lawyer->digital_guide_subscription_to}}"
                                                   name="digital_guide_subscription_to"
                                                   class="form-control @error('digital_guide_subscription_to') is-invalid @enderror">
                                            @error('digital_guide_subscription_to')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-1">

                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
                                <a href="{{route('admin.digital-guide.index')}}" type="reset"
                                   class="btn btn-outline-secondary mt-1">رجوع
                                </a>
                            </div>

                        </form>
                        <!--/ form -->

                    </div>

                </div>


            </div>
        </div>
    </div>

    <!-- END: Content-->
@endsection
@section('scripts')

    @include('admin.digital_guide.includes.edit-profile-js')
@endsection
