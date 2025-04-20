@extends('site.layouts.main')
@section('title',' استشارات محالة')
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
                                        <th>نوع الاستشارة</th>
                                        <th> الخدمة</th>
                                        <th>درجة الاهمية</th>
                                        <th>التفاصيل</th>
                                        <th>تاريخ الاحالة</th>
                                        <th> الرد</th>
                                    </tr>
                                    @foreach($reservations as $reservation)

                                        <tr style="text-align:  center">
                                            <td>{{$reservation->id}}</td>
                                            <td class="view-message text-right dont-show">
                                                {{ $reservation->client->myname  }}
                                            </td>
                                            <td class="view-message text-right">
                                                {{ $reservation->service->title  }}
                                            </td>
                                            <td class="view-message text-right">
                                                {{ $reservation->type->title  }}
                                            </td>
                                            <td class="view-message text-right">
                                                {{  is_null($reservation->importanceRel) ? "-" : $reservation->importanceRel->title }}
                                            </td>
                                            <td class="view-message text-right">
                                                <div
                                                    style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                    class="span4 proj-div" data-toggle="modal"
                                                    data-target="#GSCCModal{{$reservation->id}}">
                                                    عرض التفاصيل
                                                </div>
                                                <div id="GSCCModal{{$reservation->id}}" class="modal fade" tabindex="-1"
                                                     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel"> تفاصيل
                                                                    الاستشارة </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label> العميل : </label>
                                                                        <div class="mb-1">
                                                                            <span id="client_name"
                                                                                  class="form-control">{{$reservation->client->myname}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label> الجوال : </label>
                                                                        <div class="mb-1">
                                                                            <span id="client_phone"
                                                                                  class="form-control">{{$reservation->client->mobil}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label> الايميل : </label>
                                                                        <div class="mb-1">
                                                                            <span id="client_email"
                                                                                  class="form-control">{{$reservation->client->email}}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label> نوع الاستشارة : </label>
                                                                        <div class="mb-1">
                                                                            <span id="service"
                                                                                  class="form-control">{{$reservation->service->title}}</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">


                                                                    <div class="col-lg-6">
                                                                        <label> الخدمة : </label>
                                                                        <div class="mb-1">
                                                                            <span id="service"
                                                                                  class="form-control">{{$reservation->type->title}}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label> درجة الاهمية : </label>
                                                                        <div class="mb-1">
                                                                            <span id="service"
                                                                                  class="form-control">{{  is_null($reservation->importanceRel) ? "-" : $reservation->importanceRel->title }}</span>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <label> وصف الطلب : </label>
                                                                        <div class="mb-1">
                                                                            <textarea id="description" rows="5"
                                                                                      class="form-control"
                                                                                      disabled>  {{ $reservation->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                @if(!is_null($reservation->file))
                                                                    <a target="_blank" class="btn btn-primary"
                                                                       href="{{$reservation->file}}">
                                                                        مرفقات العميل
                                                                    </a>
                                                                @endif
                                                                <br>
                                                                <hr>

                                                                @if($reservation->replay_status ==1)
                                                                    <div class="row ">
                                                                        <div class="col-lg-12">
                                                                            <label> عنوان الرد : </label>
                                                                            <div class="mb-1">
                                                                                <span id="service"
                                                                                      class="form-control">{{$reservation->replay_subject}}</span>

                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <label> الرد على الاستشارة : </label>
                                                                            <div class="mb-1">
                                                                                <textarea id="replay" rows="5"
                                                                                          class="form-control"
                                                                                          disabled>{{ $reservation->replay_content }}</textarea>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <br>
                                                                    @if(!is_null($reservation->replay_file))
                                                                        <a target="_blank" class="btn btn-primary"
                                                                           href="{{$reservation->replay_file}}">
                                                                            مرفقات الرد
                                                                        </a>
                                                                    @endif

                                                                @else
                                                                    <a title="رد"
                                                                       style=""
                                                                       data-id="{{$reservation->id}}"
                                                                       class=" theme-btn m-2 lawyer-send-client-advisory-services-reservations-final btn btn-success">
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

                                            <td class="view-message text-center">
                                                {{GetArabicDate2($reservation->accept_date)}}
                                            </td>

                                            <td class="view-message text-right">
                                               @if($reservation->reservation_status ==5)
                                                   تم الرد
                                                @else
                                                <a title="رد"
                                                   style=""
                                                   data-id="{{$reservation->id}}"
                                                   class=" theme-btn m-2 lawyer-send-client-advisory-services-reservations-final btn btn-success">
                                                    <span class="txt">ارسال رد   </span>
                                                </a>

                                                @endif
                                            </td>
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

    <div id="sendLawyerReplay" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>ارسال رد للعميل</h2>
                </div>
                <div class="modal-body text-right">
                    <form id="sendLawyerReplayForm"
                          action="{{route('site.lawyer.client_advisory_services_reservations.SendFinalReplay')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <div>
                                <label> عنوان الرسالة :</label>
                                <input type="text" name="replay_subject"
                                       class="form-control message" >
                                <span style="display: block;text-align: right; color: #dc3545!important"
                                      class="mail-text-danger error-text replay_subject_error"></span>
                            </div>
                            <div>
                                <label> نص الرسالة :</label>
                                <textarea rows="3" name="replay_content" class="form-control" >

                                </textarea>
                                <span style="display: block;text-align: right; color: #dc3545!important"
                                      class="mail-text-danger error-text replay_content_error"></span>
                            </div>
                            <div id="reason">
                                <label> مرفقات :</label>
                                <input type="file" name="replay_file" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">ارسال</button>
                            <button type="button"
                                    class="btn btn-danger close_client_advisory_services_reservations_sendMail_btn"
                                    data-dismiss="modal">
                                إغــلاق
                            </button>

                        </div>
                    </form>
                </div>

            </div>
        </div>

        <script>
            $('.close_client_advisory_services_reservations_sendMail_btn').on('click', function () {
                $('#sendLawyerReplay').modal('hide');
            });
            $(document).on('click', '.lawyer-send-client-advisory-services-reservations-final', function (e) {
                e.preventDefault();
                let pid = $(this).attr('data-id');
                $('#sendLawyerReplayForm #id').val(pid);
                $('#sendLawyerReplay').modal('show');

            });

            $('#sendLawyerReplayForm').on('submit', function (event) {
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
                        $('#sendLawyerReplay').modal('hide');

                        Swal.fire(
                            'تهانينا !',
                            'لقد تم ارسال الرد على الاستشارة بنجاح',
                            'success'
                        ).then(function () {
                            location.reload();
                        })

                    },

                    error: function (error) {
                        $.each(error.responseJSON.errors, function (key, value) {
                            $('.' + key + '_error').text(value);
                        });
                        $('#sendLawyerReplay').modal('show');

                    }
                });
            });

        </script>

@endsection
