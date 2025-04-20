@extends('site.layouts.main')
@section('title','طلبات الخدمة')
@section('content')
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
            padding: 10px !important;
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

        .send-mail {
            font-size: 15px;
            padding: 5px;
        }

        .avatar {
            width: 50px;
            border-radius: 50%;
        }

        .modal-header h2 {
            font-size: 25px;
        }

        .modal-content {
            direction: rtl;
        }

        #reason label {
            float: right
        }

        .modal-footer a, .modal-footer button {
            padding: 8px 25px;
            margin-left: 15px;
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
                                    <h3> طلبات الخدمات محولة لك </h3>
                                </div>

                                <table class="table table-inbox table-hover text-center">
                                    <tbody>
                                    <tr>
                                        <th>رقم التذكرة</th>
                                        <th>اسم العميل</th>
                                        <th>الخدمة</th>
                                        <th>التفاصيل</th>
                                        <th>حالة الدفع</th>
                                        <th>حالة الرد</th>
{{--                                        <th>حالة الطلب</th>--}}
                                        <th>التاريخ</th>
                                        {{--                                        <th>مراسلة</th>--}}
                                    </tr>
                                    @foreach($requests as $request)

                                        <tr data-link="/lawyer-view-sent-message/{{ $request->id }}">
                                            <td>{{$request->id}}</td>
                                            <td class="view-message text-right dont-show">
                                                {{ ($request->client) ? $request->client->myname : "-" }}
                                            </td>
                                            <td class="view-message text-right">
                                                {{ ($request->type) ? $request->type->title : "-" }}
                                            </td>
                                            <td class="view-message text-right">
                                                <div
                                                    style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                    class="span4 proj-div" data-toggle="modal"
                                                    data-target="#GSCCModal{{$request->id}}">
                                                    عرض التفاصيل
                                                </div>
                                                <div id="GSCCModal{{$request->id}}" class="modal fade" tabindex="-1"
                                                     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel"> تفاصيل
                                                                    الطلب </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label> العميل : </label>
                                                                        <div class="mb-1">
                                                                            <span id="client_name"
                                                                                  class="form-control">{{$request->client->myname}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label> الجوال : </label>
                                                                        <div class="mb-1">
                                                                            <span id="client_phone"
                                                                                  class="form-control">{{$request->client->mobil}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label> الايميل : </label>
                                                                        <div class="mb-1">
                                                                            <span id="client_email"
                                                                                  class="form-control">{{$request->client->email}}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label> الخدمة : </label>
                                                                        <div class="mb-1">
                                                                            <span id="service"
                                                                                  class="form-control">{{$request->type->title}}</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label> مستوى الطلب : </label>
                                                                        <div class="mb-1">
                                                                            <span id="priority"
                                                                                  class="form-control">{{$request->priority  == 1 ? 'عاجل جداً' : 'مرتبط بموعد'}}</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label> وصف الطلب : </label>
                                                                        <div class="mb-1">
                                                                            <textarea id="description" rows="5"
                                                                                      class="form-control"
                                                                                      disabled>  {{ $request->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                @if(!is_null($request->file))
                                                                    <a target="_blank" class="btn btn-primary"
                                                                       href="{{$request->file}}">
                                                                        مرفقات العميل
                                                                    </a>
                                                                @endif
                                                                <br>
                                                                <hr>
                                                                <br>

                                                                @if($request->replay_status ==1)
                                                                    <div class="row ">
                                                                        <div class="col-lg-12">
                                                                            <label> الرد على الاستشارة : </label>
                                                                            <div class="mb-1">
                                                                                <textarea id="replay" rows="5"
                                                                                          class="form-control"
                                                                                          disabled>{{ $request->replay }}</textarea>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <br>
                                                                    @if(!is_null($request->replay_file))
                                                                        <a target="_blank" class="btn btn-primary"
                                                                           href="{{$request->replay_file}}">
                                                                            مرفقات الرد
                                                                        </a>
                                                                    @endif

                                                                @else
                                                                    <a title="رد"
                                                                       style=""
                                                                       href="{{route('site.lawyer.clients-service-requests.show',$request->id)}}"
                                                                       data-id="{{$request->id}}"
                                                                       class=" theme-btn m-2 lawyer-send-client-service-request-final btn btn-success">
                                                                        <span class="txt">ارسال رد   </span>
                                                                    </a>
                                                                @endif

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default btn-secondary"
                                                                        data-dismiss="modal">اغلاق
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="inbox-small-cells">
                                                {{$request->payment_status == 1?'مدفوع':'مجانية'}}
                                            </td>
                                            <td class="inbox-small-cells">
                                                                                                @if($request->replay_status == 1)
                                                                                                    <span class="txt">تم الرد  </span>
                                                                                                @else
                                                <a title="رد" style="color: #dd9b25"
                                                   href="{{route('site.lawyer.clients-service-requests.show',$request->id)}}"
                                                   data-id="{{$request->id}}"
                                                   class=" theme-btn m-2 lawyer-send-client-service-request-final">
                                                    <span class="txt">ارسال رد   </span>
                                                </a>
                                                                                                @endif

                                            </td>
{{--                                            <td class="view-message text-center">--}}
{{--                                                @if(in_array($request->referral_status ,[0,1]))--}}
{{--                                                    <select style="height: 48px" name="referral_status"--}}
{{--                                                            data-id="{{$request->id}}"--}}
{{--                                                             class="form-control referral_status_select">--}}
{{--                                                        <option value="5">قبول / رفض</option>--}}
{{--                                                        <option value="2">قبول</option>--}}
{{--                                                        <option value="4">رفض</option>--}}
{{--                                                    </select>--}}
{{--                                                @elseif(in_array($request->referral_status ,[2,3,4]))--}}
{{--                                                    @if($request->referral_status == 2)--}}
{{--                                                        قيد الدراسة--}}
{{--                                                    @elseif($request->referral_status == 3)--}}
{{--                                                        منتهي--}}
{{--                                                    @elseif($request->referral_status == 4)--}}
{{--                                                        تم الرفض--}}
{{--                                                    @endif--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
                                            <td class="view-message text-center">
                                                {{GetArabicDate2($request->created_at)}}
                                            </td>

                                            {{--                                            <td class="inbox-small-cells ">--}}
                                            {{--                                                <a title="مراسلة العميل" style="color: #dd9b25" target="_blank"--}}
                                            {{--                                                   href="{{route('site.lawyer.clients-service-requests.ShowRequestContacts',$request->id)}}"--}}
                                            {{--                                                   class=" theme-btn m-2">--}}
                                            {{--                                                    <span class="txt"><i--}}
                                            {{--                                                            class="fa fa-envelope"></i> مراسلة العميل</span>--}}
                                            {{--                                                </a>--}}

                                            {{--                                            </td>--}}

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="sendMail" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> ارسال رد للعميل </h2>
                </div>
                <div class="modal-body text-right">

                    <form id="sendLawyerMailForm"
                          action="{{route('site.lawyer.clients-service-requests.SendFinalReplay')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="replay_from_lawyer_id" name="replay_from_lawyer_id"
                               value="{{auth()->guard('lawyer')->user()->id}}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label> العميل : </label>
                                    <div class="mb-1">
                                        <span id="client_name" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label> الجوال : </label>
                                    <div class="mb-1">
                                        <span id="client_phone" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label> الايميل : </label>
                                    <div class="mb-1">
                                        <span id="client_email" class="form-control"/>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label> الخدمة : </label>
                                    <div class="mb-1">
                                        <span id="service" class="form-control"/>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label> مستوى الطلب : </label>
                                    <div class="mb-1">
                                        <span id="priority" class="form-control"/>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label> وصف الطلب : </label>
                                    <div class="mb-1">
                                        <textarea id="description" rows="5" class="form-control" disabled></textarea>
                                    </div>
                                </div>


                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <a target="_blank" class="btn btn-primary download_service_request_file">
                                        مرفقات العميل
                                    </a>

                                </div>

                            </div>
                            <hr>
                            <br>


                            <div id="old_replay_message_div" class="row d-none ">
                                <div class="col-lg-12">
                                    <label> نص الرد السابق :</label>
                                    <textarea rows="6"
                                              class="form-control old_replay_message" disabled></textarea>
                                </div>
                            </div>
                            <div id="download_service_replay_request_old_file_div" class="row d-none">
                                <div class="col-lg-6">
                                    <a target="_blank" class="btn btn-primary download_service_replay_old_request_file">
                                        مرفقات الرد القديم
                                    </a>
                                </div>
                            </div>
                            <div id="reason">
                                <label> نص الرسالة :</label>
                                <textarea rows="6" cols="5" type="text" name="message"
                                          class="form-control message" required></textarea>
                                <span style="display: block;text-align: right; color: #dc3545!important"
                                      class="mail-text-danger error-text message_error"></span>
                            </div>
                            <div id="reason">
                                <label> مرفقات :</label>
                                <input type="file" name="file" class="form-control">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">ارسال</button>
                            <button type="button" class="btn btn-danger close_sendMail_btn" data-dismiss="modal">
                                إغــلاق
                            </button>

                        </div>
                    </form>
                </div>

            </div>
        </div>

        <script>
            $('.close_sendMail_btn').on('click', function () {
                $('#sendMail').modal('hide');
            });
            $(document).on('click', '.lawyer-send-client-service-request-final', function (e) {
                e.preventDefault();
                let btn = $(this);
                let data_id = btn.attr('data-id');
                let actionUrl = btn.attr('href');
                $.ajax({
                    url: actionUrl,
                    type: 'get',
                    success: function (response) {
                        $('#sendLawyerMailForm #id').val(data_id);
                        $('#sendLawyerMailForm #client_name').html(response.item.client.myname);
                        $('#sendLawyerMailForm #client_phone').html(response.item.client.mobil);
                        $('#sendLawyerMailForm #client_email').html(response.item.client.email);
                        $('#sendLawyerMailForm #service').html(response.item.type.title);
                        $('#sendLawyerMailForm #priority').html(response.item.priority == 1 ? 'عاجل جداً' : 'مرتبط بموعد');
                        $('#sendLawyerMailForm #description').html(response.item.description);
                        $('#sendLawyerMailForm .old_replay_message').html(response.item.replay);
                        $('#sendLawyerMailForm .download_service_request_file').attr('id', 'download_service_request_file_' + response.item.id);
                        $('#sendLawyerMailForm .download_service_replay_old_request_file').attr('id', 'download_service_replay_old_request_file_' + response.item.id);

                        let file = response.item.file;
                        if (file != null) {
                            if ($('#download_service_request_file_' + response.item.id).hasClass('d-none')) {
                                $('#download_service_request_file_' + response.item.id).removeClass('d-none');
                            }
                            $('#download_service_request_file_' + response.item.id).attr('href', file);
                        } else {
                            $('#download_service_request_file_' + response.item.id).addClass('d-none');
                        }
                        let old_replay = response.item.replay;
                        let old_replay_file = response.item.replay_file;
                        if (old_replay != null) {
                            if ($('#sendLawyerMailForm #old_replay_message_div').hasClass('d-none')) {
                                $('#sendLawyerMailForm .old_replay_message').attr('id', 'old_replay_message_' + response.item.id);
                                $('#sendLawyerMailForm #old_replay_message_' + response.item.id).html(response.item.replay);
                                $('#sendLawyerMailForm #old_replay_message_div').removeClass('d-none');
                            }

                        } else {
                            $('#sendLawyerMailForm .old_replay_message').html('');

                        }
                        if (old_replay_file != null) {
                            $('#sendLawyerMailForm .download_service_replay_old_request_file').attr('id', 'download_service_replay_old_request_file_' + response.item.id);
                            if ($('#download_service_replay_old_request_file_' + response.item.id).hasClass('d-none')) {
                                $('#download_service_replay_old_request_file_' + response.item.id).removeClass('d-none');
                            }

                            $('#download_service_replay_old_request_file_' + response.item.id).attr('href', file);
                            if ($('#download_service_replay_request_old_file_div').hasClass('d-none')) {
                                $('#download_service_replay_request_old_file_div').removeClass('d-none');
                            }
                        } else {
                            $('#download_service_replay_old_request_file_' + response.item.id).addClass('d-none');
                            if (!$('#download_service_replay_request_old_file_div').hasClass('d-none')) {
                                $('#download_service_replay_request_old_file_div').addClass('d-none');
                            }
                        }

                        $('#sendMail').modal('show');
                    }
                });

            });

            $('#sendLawyerMailForm').on('submit', function (event) {
                event.preventDefault();
                let actionUrl = $(this).attr('action');
                $.ajax
                ({
                    url: actionUrl,
                    type: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $('#sendMail').modal('hide');

                        Swal.fire(
                            'تهانينا !',
                            'لقد تم ارسال الرد على الاستشارة بنجاح',
                            'success'
                        ).then(function () {
                            location.reload();
                        })

                    }
                });
            });

            $('.referral_status_select').on('change', function (event) {
                event.preventDefault();
                let actionUrl = '{{route('site.lawyer.clients-service-requests.changeReferralStatus')}}';
                let value_1 = $(this).val();
                let request_id = $(this).attr('data-id');
                if (value_1 !=5){
                    $.ajax({
                        url: actionUrl,
                        type: 'post',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'request_id': request_id,
                            'referral_status': value_1
                        },
                        success: function (response) {

                            if (response.status) {
                                Swal.fire(
                                    'تهانينا !',
                                    'لقد تحديث حالة القبول  بنجاح',
                                    'success'
                                ).then(function () {
                                    location.reload();
                                })
                            }
                        },
                        error: function () {
                            Swal.fire({
                                title: "مشكلة !",
                                text: " هناك مشكلة في النظام يرجى مراجعة مدير النظام !",
                                icon: "error",
                                confirmButtonText: "موافق",
                                customClass: {confirmButton: "btn btn-primary"},
                                buttonsStyling: !1
                            })
                        }

                    })
                }



            })
        </script>

@endsection
