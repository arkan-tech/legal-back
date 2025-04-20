@extends('site.layouts.main')
@section('title','طلب خدمة')
@section('content')

    <style>
        .custom-file-label::after {
            left: 0;
            right: unset !important;
        }

        .custom-file {
            margin-bottom: 25px !important
        }
    </style>

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
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->
                    <div class="styled-form">

                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12">

                                <div class="inbox-head">
                                    <h3> طلب خدمة جديد </h3>
                                </div>

                                <div class="styled-form" style="margin-top: 25px;">
                                    <form action="{{route('site.client.service-request.store-client-service') }}"
                                          id="store_client_service_form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card ">
                                            <div class=" card-header">
                                                معلومات شخصية
                                            </div>
                                            <div class=" card-body">
                                                <div class="form-group">
                                                    <label for="">الاسم بالكامل</label>
                                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                                    <input type="text" name="client_name" id="name"
                                                           class="form-control">
                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_client_name_error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">رقم الجوال</label>
                                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                                    <input type="number" name="client_mobile" id="mobile"
                                                           class="form-control">
                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_client_mobile_error"></span>
                                                </div>
{{--                                                <div class="form-group">--}}
{{--                                                    <label for="">رقم الهوية</label>--}}
{{--                                                    <span class="adon-icon"><span class="fa fa-user"></span></span>--}}
{{--                                                    <input type="text" name="client_idnumber" id="idnumber"--}}
{{--                                                           class="form-control">--}}
{{--                                                    <span style="display: block;text-align: right;"--}}
{{--                                                          class="text-danger error-text store_client_service_client_idnumber_error"></span>--}}
{{--                                                </div>--}}

                                                <div class="form-group">
                                                    <label for=""> البريد الالكتروني</label>
                                                    <span class="adon-icon"><span
                                                            class="fa fa-envelope-o"></span></span>
                                                    <input type="email" name="client_email" class="form-control"
                                                           id="email">
                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_client_email_error"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for=""> الجهة</label>
                                                    <span class="adon-icon"><span class="fa fa-user"></span></span>
                                                    <select class="form-control" id="type" name="client_type"
                                                            style="height: 50px">
                                                        <option value="1">فرد</option>
                                                        <option value="2">مؤسسة</option>
                                                        <option value="3">شركة</option>
                                                        <option value="4">جهة حكومية</option>
                                                        <option value="5">هيئة</option>
                                                    </select>
                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_client_type_error"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mt-2">
                                            <div class=" card-header">
                                                معلومات الخدمة
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for=""> الخدمة</label>
                                                    <span class="adon-icon">
                                                <span class="fa fa-cog"></span></span>
                                                    <select id="type" class="form-control" name="service_type"
                                                            style="height: 50px">
                                                        @foreach($services as $service)
                                                            <option
                                                                value="{{$service->id}}" {{$service->id ==$service_id ?'selected':''}}> {{$service->title}}  </option>
                                                        @endforeach
                                                    </select>
                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_service_type_error"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for=""> مستوى الطلب</label>

                                                    <span class="adon-icon"><span class="fa fa-cog"></span></span>
                                                    <select id="priority" class="form-control" name="service_priority"
                                                            style="height: 50px">
                                                        <option value="1">عاجل جدا</option>
                                                        <option value="2">مرتبط بموعد</option>
                                                    </select>

                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_priority_error"></span>
                                                </div>

                                                <div class="form-group">
                                                    <label for=""> محتوى الطلب</label>

                                                    <textarea cols="6" style="height: 150px" rows="6"
                                                              class="form-control"
                                                              type="text" id="description"
                                                              name="service_description"></textarea>
                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_service_description_error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="file">المرفقات</label>
                                                    <input type="file" name="service_file" class="form-control"
                                                           id="file"
                                                           accept=".png,.jpg,.jpeg">
                                                    <span style="display: block;text-align: right;"
                                                          class="text-danger error-text store_client_service_service_file_error"></span>
                                                </div>
                                            </div>
                                        </div>


                                        <br>
                                        <div class="clearfix">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="theme-btn btn-style-three"><span
                                                        class="txt"> تأكيد الطلب </span></button>

                                                <span style="display: none;" id="AjaxLoader" class="">
                                    <img src="{{asset('/site/images/loader2.gif')}}">
                                </span>

                                            </div>
                                        </div>

                                        <div style="display: none !important"
                                             class="m-alert alert-dismissible fade m-alert--outline alert alert-success  show"
                                             id="mail-success-div">
                                            <strong>تنبيه!</strong> تم اضافة طلب الخدمة الخاص بك بنجاح . وسيتم التواصل
                                            معك فى اقرب وقت.

                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </div>
    </section>

@endsection
@section('site_scripts')
    <script>
        $('#store_client_service_form').on('submit', function (event) {
            event.preventDefault();
            let actionUrl = $(this).attr('action');
            let formData = getFormInputs($(this))
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $("#AjaxLoader").show();
                },
                success: function (response) {

                    if (response.status) {
                        $("#AjaxLoader").hide();
                        Swal.fire(
                            'تهانينا !',
                            response.msg,
                            'success'
                        ).then(function () {
                            location.href = '{{route('site.client.show.login.form')}}'
                        })
                    }
                },
                error: function (error) {
                    $("#AjaxLoader").hide();
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.store_client_service_' + key + '_error').text(value);
                    });
                }

            });

        });
    </script>
@endsection
