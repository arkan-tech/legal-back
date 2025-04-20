@extends('site.layouts.main')
@section('title','رسائلى ليمتاز')
@section('content')

    <style>
        .apply-office {
            font-family: 'Tajawal Bold';
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
                        <a style="padding: 15px 30px; float: left" class="theme-btn btn-style-three"
                           href="{{route('site.client.ymtaz-contact.create')}}">
                        <span class="txt" style="font-size: 15px">
                            <i class="fa fa-plus"></i> راسل يمتاز
                        </span>
                        </a>

                        <h2 style="display: inline-block"> الملف الشخصى </h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->

                    <div class="row">

                        @include('site.client.client_right_menu')

                        <div class="col-lg-10 col-md-12 col-sm-12">

                            <div class="inbox-head">
                                <h3> رسائلى ليمتاز </h3>
                            </div>

                            <table class="table table-inbox table-hover">
                                <tr>
                                    <th>عنوان الرسالة</th>
                                    <th>التفاصيل</th>
                                    <th>نوع الرسالة</th>
                                    <th>تاريخ الرسالة</th>
                                    <th>المرفقات</th>
                                    <th> رد يمتاز</th>

                                </tr>
                                <tbody>

                                @foreach($messages as $request)
                                    <tr>

                                        <td class="view-message text-right">
                                            {{ $request->subject }}
                                        </td>
                                        <td class="view-message text-right">


                                            <div
                                                style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                class="span4 proj-div" data-toggle="modal"
                                                data-target="#GSCCModal{{$request->id}}">
                                                محتوى الرسالة
                                            </div>

                                            <div id="GSCCModal{{$request->id}}" class="modal fade" tabindex="-1"
                                                 role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel"> محتوى
                                                                الرسالة </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $request->details }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">اغلاق
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td class="inbox-small-cells text-right">
                                            {{ $request->type() }}
                                        </td>
                                        <td class="view-message text-right">
                                            {{GetArabicDate2($request->created_at)}}
                                        </td>

                                        <td class="text-right">
                                            @if(!is_null($request->file))
                                                <a href="{{$request->file}}" target="_blank"> المرفقات</a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        @if ($request->reply != '')
                                            <td>
                                                <div
                                                    style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                    class="span4 proj-div" data-toggle="modal"
                                                    data-target="#modal{{$request->id}}">
                                                    عرض رد يمتاز
                                                </div>

                                                <div id="modal{{$request->id}}" class="modal fade" tabindex="-1"
                                                     role="dialog" aria-labelledby="myModalLabel1"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title"
                                                                    id="myModalLabel1"> {{ $request->ymtaz_reply_subject }} </h4>
                                                            </div>
                                                            <div class="modal-body text-justify">
                                                                {{ $request->reply }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">اغلاق
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
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
                    <h2> ارسال رساله للعميل </h2>
                </div>
                <div class="modal-body text-right">
                    <div style="display: none !important" class="m-alert m-alert--outline alert alert-success  show"
                         id="mail-success-div">
                        </button>
                        <strong>تنبيه!</strong> تم ارسال الرساله بنجاح للعميل وسيقوم بالتواصل معكم..
                    </div>

                    <form id="sendLawyerMailForm">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="clientID" class="form-control" id="clientID">

                            <div id="reason">
                                <label>موضوع الرسالة :</label>
                                <input type="text" name="subject" class="form-control subject">
                                <span style="display: block;text-align: right;color: #dc3545!important"
                                      class="mail-text-danger error-text subject_error"></span>
                            </div>

                            <div id="reason">
                                <label> نص الرسالة :</label>
                                <textarea rows="6" cols="5" type="text" name="message"
                                          class="form-control message"></textarea>
                                <span style="display: block;text-align: right; color: #dc3545!important"
                                      class="mail-text-danger error-text message_error"></span>
                            </div>

                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">ارسال</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغــلاق</button>
                </div>
                </form>
            </div>

        </div>
    </div>

@endsection
@section('site_scripts')
    <script>
        $(document).ready(function () {
            $('div').on('click', '.send-mail', function (e) {
                e.preventDefault();
                $('#sendMail').modal();

                $('#clientID').val($(this).attr('data-id'));

            });

            $('#sendLawyerMailForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax
                ({
                    url: "#",
                    type: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if ($.isEmptyObject(data.error)) {
                            $("#sendLawyerMailForm")[0].reset();
                            $('.mail-text-danger').hide();
                            $('#clientID').val('');

                            $('#mail-success-div').attr('style', 'display: block !important');
                            setTimeout(function () {
                                $('#mail-success-div').attr('style', 'display: none !important');
                                $('#sendMail').modal('hide');

                                //window.location.reload();
                            }, 3000);

                        } else {
                            $.each(data.error, function (key, value) {
                                $('.' + key + '_error').text(value);
                            });
                        }

                    }
                });
            });
        });
    </script>

@endsection
