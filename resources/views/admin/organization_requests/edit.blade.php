@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.organization-requests.update')}}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">معلومات الطلب</h4>
                                </div>
                                <input type="hidden" name="id" value="{{$request->id}}">
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> مستوى الطلب </label>
                                            <select id="priority" name="priority" class="form-control" disabled>
                                                <option value="1" {{$request->priority==1?'selected':''}}>عاجل جدا
                                                </option>
                                                <option value="2" {{$request->priority==1?'selected':''}}>مرتبط بموعد
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> حالة الدفع </label>
                                            <select id="priority" name="payment_status" class="form-control" disabled>
                                                <option value="1" {{$request->payment_status==1?'selected':''}}> مكتمل
                                                </option>
                                                <option value="2" {{$request->payment_status==2?'selected':''}}> ملغي
                                                </option>
                                                <option value="3" {{$request->payment_status==3?'selected':''}}> مرفوض
                                                </option>
                                                <option value="null" {{$request->payment_status==null?'selected':''}}>
                                                    غير محدد
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> مضمون الطلب </label>
                                            <textarea class="form-control "
                                                      name="about" rows="5" disabled>
                                                {{$request->description}}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الحالة </label>
                                            <select id="request_status" name="status" class="form-control select2">
                                                <option value="0" {{$request->status==0?'selected':''}}> جديد</option>
                                                <option value="1" {{$request->status==1?'selected':''}}> قبول</option>
                                                <option value="2" {{$request->status==2?'selected':''}}> رفض</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1 d-none" id="request_price">
                                            <label class="form-label" for="accountFirstName"> تحديد سعر
                                                الإستشارة </label>
                                            <input type="number" id="request_price_input" name="price"
                                                   class="form-control" value="{{$request->price}}">
                                            @error('price')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">

                                        <div class="col-12 col-sm-4 mb-1">

                                            <div class="">
                                                @if(!is_null($request->file))
                                                    <label class="mb-1"> مرفق </label>
                                                    @php
                                                        $file_extention = getFileExtention($request->file);
                                                    @endphp

                                                    @if($file_extention != 'pdf' )
                                                        <img src="{{$request->file}}"
                                                             id="account-upload-logo" class="uploadedLogo rounded me-50"
                                                             alt="profile image" height="300" width="300"/>
                                                    @else
                                                        <iframe src="{{$request->file}}"
                                                                style="width:600px; height:500px;"
                                                                frameborder="0"></iframe>
                                                    @endif
                                                    <div class="mt-75 ">
                                                        <div>
                                                            <a href="{{$request->file}}"
                                                               download="{{$request->file.'_file'}}"
                                                               class="btn btn-sm btn-outline-secondary mb-75">تنزيل
                                                                المرفق
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                                <!-- upload and reset button -->

                                                <!--/ upload and reset button -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </button>
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
    <script>
        $(document).ready(function () {
            let ready_status = '{{$request->status}}';
            let check_if_has_class = $('#request_price').hasClass('d-none');
            if (ready_status == 1) {
                $('#request_price').removeClass('d-none');
                $('#request_price_input').attr("required", true);
            }
        });
        $('#request_status').on('change', function () {
            let val = $(this).val();
            console.log(val);
            let check_if_has_class_on_change = $('#request_price').hasClass('d-none');


            if (val == 1) {
                if (check_if_has_class_on_change) {
                    $('#request_price').removeClass('d-none');
                    $('#request_price_input').attr("required", true);
                }
            } else {
                if (check_if_has_class_on_change == false) {
                    $('#request_price').addClass('d-none');
                    $('#request_price_input').attr("required", false);

                }

            }
        })
    </script>

@endsection
