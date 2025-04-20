@extends('site.layouts.main')
@section('title','طلب هيئة استشارية')
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
                        <h2> الملف الشخصى </h2>
                        <div class="separate"></div>
                    </div>
                    <!--Login Form-->
                    <div class="styled-form register-form">

                        <div class="row">

                            @include('site.lawyer_right_menu', array('lawyer'=> $lawyer))
                            <div class="col-lg-10 col-md-12 col-sm-12">
                                <div class="inbox-head">
                                    <h3 style="display: inline-block"> هيئة استشارية </h3>
                                </div>
                                <div class="styled-form register-form" style="margin-top: 25px;">
                                    <form id="make-service-request">
                                        @csrf
                                        <div class="form-group">
                                            <span class="adon-icon">
                                                <span class="fa fa-cog"></span>
                                            </span>
                                            <select id="type" name="type" class="form-control">
                                                <option value=""> الهيئة الإستشارية</option>
                                                <?=GetSelectItem('advisorycommittees', 'title');?>
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text type_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-cog"></span></span>
                                            <select id="priority" name="priority" class="form-control">
                                                <option value=""> مستوى الطلب</option>
                                                <option value="1">عاجل جدا</option>
                                                <option value="2">مرتبط بموعد</option>
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text priority_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" cols="6" style="height: 150px" rows="6"
                                                      type="text" id="description" name="description" value=""
                                                      placeholder="محتوى الطلب"></textarea>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text description_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">المرفقات</label>
                                            <input class="form-control" type="file" name="file" id="file" accept=".png,.jpg,jpeg ,.pdf">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text file_err"></span>
                                        </div>
                                        <br>
                                        <div class="clearfix">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="theme-btn btn-style-three">
                                                    <span class="txt"> تأكيد الطلب </span>
                                                </button>
                                                <span style="display: none;" id="AjaxLoader" class="">
                                                         <img src="{{asset('site/images/loader2.gif')}}">
                                                </span>

                                            </div>
                                        </div>
                                        <div style="display: none !important"
                                             class="m-alert m-alert--outline alert alert-success  show"
                                             id="mail-success-div">
                                            <strong>تنبيه!</strong>
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



    <script>
        $(document).ready(function () {
            $('#make-service-request').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    url: "{{route('site.lawyer.organization-requests.store')}}",
                    type: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $("#AjaxLoader").show();
                    },
                    success: function (data) {
                        $("#AjaxLoader").hide();
                        if (data.success == 1) {
                            Swal.fire(
                                'تنبيه !',
                                ' تم اضافة طلب الهيئة الإستشارية الخاص بك بنجاح . وسيتم التواصل معك فى اقرب وقت.',
                                'success'
                            ).then(function () {
                                $("#make-service-request")[0].reset();
                                $('.text-danger').hide();

                            });
                        }
                    },
                    error: function (error) {
                        $.each(error.responseJSON.errors, function (key, value) {
                            $('.' + key + '_err').text(value);
                        });
                    }

                });

            });
        });
    </script>

@endsection
