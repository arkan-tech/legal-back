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
                    <div class="row">
                        @include('site.client.client_right_menu')
                        <div class="col-lg-10 col-md-12 col-sm-12">
                            <div class="inbox-head">
                                <h3> راسلنا </h3>
                            </div>
                            <div class="styled-form register-form" style="margin-top: 25px;">
                                <form id="send-client-to-ymtaz-message-form" method="post"
                                      action="{{route('site.client.ymtaz-contact.store')}}">
                                    @csrf
                                    <input type="hidden" value="{{$client->id}}"
                                           name="client_id">
                                    <div class="form-group">
                                        <label for="">عنوان الرسالة</label>
                                        <input type="text" class="form-control" id="name" name="subject">
                                        <span style="display: block;text-align: right;"
                                              class="text-danger error-text save_client_ymtaz_message_subject_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for=""> الرسالة</label>
                                        <textarea cols="6" class="form-control" style="height: 150px" rows="6"
                                                  type="text" id="description"
                                                  name="details"></textarea>

                                        <span style="display: block;text-align: right;"
                                              class="text-danger error-text save_client_ymtaz_message_details_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for=""> خيارات</label>
                                        <span class="adon-icon"><span class="fa fa-cog"></span></span>
                                        <select class="form-control" style="height:50px;" id="type" name="type">
                                            <option value="1">طلب خدمة</option>
                                            <option value="2">شكوى أو بلاغ</option>
                                        </select>
                                        <span style="display: block;text-align: right;"
                                              class="text-danger error-text save_client_ymtaz_message_type_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">المرفقات</label>
                                        <input type="file" name="file" class="form-control" id="file">
                                        <span style="display: block;text-align: right;"
                                              class="text-danger error-text save_client_ymtaz_message_file_error"></span>
                                    </div>
                                    <br>
                                    <div class="clearfix">
                                        <div class="form-group pull-right">
                                            <button type="submit" class="theme-btn btn-style-three"><span class="txt"> ارسال  </span>
                                            </button>

                                            <span style="display: none;" id="AjaxLoader" class="">
                                    <img src="{{asset('site/images/loader2.gif')}}">
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
    </section>

@endsection
@section('site_scripts')
    <script>
            $('#send-client-to-ymtaz-message-form').on('submit', function (event) {
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
                            'تم استلام رسالتك بنجاح . وسيتم  الرد عليك فى اقرب وقت. , تابع ايميلك .',
                            'success'
                        ).then(function () {
                            form[0].reset();
                        });
                    },
                    error: function (error) {
                        $.each(error.responseJSON.errors, function (key, value) {
                            $('.save_client_ymtaz_message_' + key + '_error').text(value);
                        });
                    }
                });

        });
    </script>
@endsection
