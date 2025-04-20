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
                        <h2> الملف الشخصى </h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->
                    <div class="styled-form register-form">

                        <div class="row">

                            @include('site.client.client_right_menu')

                            <div class="col-lg-10 col-md-12 col-sm-12">

                                <div class="inbox-head">
                                    <h3> طلب خدمة جديد </h3>
                                </div>

                                <div class="styled-form register-form" style="margin-top: 25px;">
                                    <form action="{{ route('site.client.service-request.store') }}"
                                          id="make-service-request-form" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" value="{{$client->id}}" name="client_id">

                                        <div class="form-group">
                                            <label for="">نوع الخدمة</label>
                                            <select id="type" class="form-control select2" name="type" style="height: 50px">
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}" {{$service->id == $id ?'selected':''}}> {{$service->title}}  </option>
                                                @endforeach
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_service_request_type_err"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for=""> درجة الاهمية</label>
                                            <select id="importance" class="form-control select2" name="priority" style="height: 50px">
                                                @foreach($importance as $item)
                                                    <option value="{{$item->id}}" > {{$item->title}}  </option>
                                                @endforeach
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_service_request_priority_err"></span>
                                        </div>

                                        <div class="form-group">
                                            <textarea cols="6" style="height: 150px" rows="6" class="form-control"
                                                      type="text" id="description" name="description"
                                                      placeholder="محتوى الطلب"></textarea>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_service_request_description_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">المرفقات</label>
                                            <input type="file" name="file" class="form-control" id="file"
                                                   accept=".png,.jpg,.jpeg">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_service_request_file_err"></span>
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
        $('#make-service-request-form').on('submit', function (event) {
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
                        location.href = response.payment_url;
                        {{--Swal.fire(--}}
                        {{--    'تهانينا !',--}}
                        {{--    response.msg,--}}
                        {{--    'success'--}}
                        {{--).then(function () {--}}
                        {{--    location.href = '{{route('site.client.service-request.index')}}'--}}
                        {{--})--}}
                    }
                },
                error: function (error) {
                    $("#AjaxLoader").hide();
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.save_client_service_request_' + key + '_err').text(value);
                    });
                }

            });

        });
    </script>
@endsection
