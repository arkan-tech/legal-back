@extends('site.layouts.main')
@section('title','راسل يمتاز')
@section('content')

    <style>
        .custom-file-label::after {
            left: 0;
            right: unset !important;
        }

        .custom-file {
            margin-bottom: 25px !important
        }

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
                                    <h3> راسلنا </h3>
                                </div>

                                <div class="styled-form register-form" style="margin-top: 25px;">
                                    <form id="make-service-request"
                                          action="{{route('site.lawyer.contact-ymtaz.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$lawyer->id}}" name="lawyer_id">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="subject"
                                                   placeholder="عنوان الرسالة">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text subject_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <textarea cols="6" class="form-control" style="height: 150px" rows="6"
                                                      type="text" id="description" name="details"
                                                      placeholder="الرسالة">
                                            </textarea>

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text details_err"></span>
                                        </div>

                                        <div class="form-group">
                                            <span class="adon-icon"><span class="fa fa-cog"></span></span>
                                            <select class="form-control" id="type" name="type">
                                                <option value=""> خيارات</option>
                                                <option value="1">طلب خدمة</option>
                                                <option value="2">شكوى أو بلاغ</option>
                                            </select>

                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text type_err"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="file">المرفقات</label>
                                            <input type="file" name="file" class="form-control" id="file"
                                                   accept=".jpg , .jpeg, .png,.pdf">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text file_err"></span>
                                        </div>

                                        <br>
                                        <div class="clearfix">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="theme-btn btn-style-three"><span
                                                        class="txt"> ارسال  </span></button>

                                                <span style="display: none;" id="AjaxLoader" class="">
                                    <img src="{{asset('/site/images/loader2.gif')}}">
                                </span>
                                            </div>
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
        $(document).ready(function () {
            $('#make-service-request').on('submit', function (event) {
                event.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
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
                        Swal.fire(
                            'نجاح !',
                            'تم استلام رسالتك بنجاح . وسيتم  الرد عليك فى اقرب وقت.',
                            'success'
                        ).then(function () {
                            $("#make-service-request")[0].reset();
                            $('.text-danger').hide();
                        });
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
