@extends('site.layouts.main')
@section('title','طلبات الخدمة')
@section('content')

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">


                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        {{--                        <a style="padding: 15px 30px; float: left" class="theme-btn btn-style-three"--}}
                        {{--                           href="{{route('site.client.advisory-services.create')}}">--}}
                        {{--                        <span class="txt" style="font-size: 15px">--}}
                        {{--                            <i class="fa fa-plus"></i> طلب استشارة جديدة--}}
                        {{--                        </span>--}}
                        {{--                        </a>--}}

                        <h2 style="display: inline-block"> الملف الشخصى </h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->

                    <div class="row">

                        @include('site.client.client_right_menu')

                        <div class="col-lg-10 col-md-12 col-sm-12">


                            <div class="inbox-head">
                                <h3> طلبات الاستشارات </h3>
                            </div>

                            <table class="table table-inbox table-hover text-center">

                                <tr>
                                    <th> #</th>
                                    <th> نوع الاستشارة</th>
                                    <th> نوع الخدمة</th>
                                    <th> درجة الاهمية</th>
                                    <th>محتوى الطلب</th>
                                    <th>حالة الرد</th>
                                    <th> السعر</th>
                                    <th>تاريخ الطلب</th>
                                </tr>

                                <tbody>

                                @foreach($reservations as $item)
                                    <tr class="text-center">

                                        <td class="view-message text-right">
                                            {{  $item->id }}
                                        </td>
                                        <td class="view-message text-right">
                                            {{  $item->service->title }}
                                        </td>
                                        <td class="view-message text-right">
                                            {{  $item->type->title }}
                                        </td>
                                        <td class="view-message text-right">
                                            {{$item->importanceRel->title}}
                                        </td>
                                        <td class="view-message text-right">
                                            <div
                                                style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                class="span4 proj-div" data-toggle="modal"
                                                data-target="#GSCCModal{{$item->id}}">
                                                عرض محتوى الطلب
                                            </div>
                                            <div id="GSCCModal{{$item->id}}" class="modal fade" tabindex="-1"
                                                 role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel"> محتوى الطلب
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <label> المحتوى : </label>
                                                                    <div class="mb-1">
                                                                            <textarea id="description" rows="5"
                                                                                      class="form-control"
                                                                                      disabled>  {{ $item->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <label> تاريخ الموعد : </label>
                                                                    <div class="mb-1">
                                                                        @if(!is_null($item->appointment))
                                                                            <span
                                                                                class="form-control">{{$item->appointment->date}}</span>
                                                                        @else
                                                                            لا يوجد
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <label> وقت الموعد : </label>
                                                                    <div class="mb-1">
                                                                        @if(!is_null($item->appointment))
                                                                            <span
                                                                                class="form-control">   {{$item->appointment->time_from .' '.' : '.$item->appointment->time_to}}</span>
                                                                        @else
                                                                            لا يوجد
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            @if(!is_null($item->file))
                                                                <a target="_blank" class="btn btn-primary"
                                                                   href="{{$item->file}}">
                                                                    مرفقات العميل
                                                                </a>
                                                            @endif
                                                            <br>

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
                                            @if($item->replay_status == 0 )
                                                انتظار
                                            @else
                                                <div
                                                    style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                    class="span4 proj-div" data-toggle="modal"
                                                    data-target="#GSCCModalReplay{{$item->id}}">
                                                    عرض الرد
                                                </div>
                                                <div id="GSCCModalReplay{{$item->id}}" class="modal fade" tabindex="-1"
                                                     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel"> تفاصيل
                                                                    الرد </h4>
                                                            </div>
                                                            <div class="modal-body">


                                                                <div class="row ">
                                                                    <div class="col-lg-12">
                                                                        <label>عنوان الرد على الاستشارة : </label>
                                                                        <div class="mb-1">
                                                                                <textarea id="replay" rows="5"
                                                                                          class="form-control"
                                                                                          disabled>{{ $item->replay_subject }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12">
                                                                        <label> الرد على الاستشارة : </label>
                                                                        <div class="mb-1">
                                                                                <textarea id="replay" rows="5"
                                                                                          class="form-control"
                                                                                          disabled>{{ $item->replay_content }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label> تاريخ الرد : </label>
                                                                        <div class="mb-1">
                                                                            <span
                                                                                class="form-control">{{$item->replay_date}}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label> وقت الرد : </label>
                                                                        <div class="mb-1">
                                                                            <span
                                                                                class="form-control">{{$item->replay_time}}</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <br>
                                                                @if(!is_null($item->replay_file))
                                                                    <a target="_blank" class="btn btn-primary"
                                                                       href="{{$item->replay_file}}">
                                                                        مرفقات الرد
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
                                            @endif
                                        </td>
                                        <td class="">
                                            {{$item->price .'رس'}}
                                        </td>
                                        <td class="view-message">
                                            {{GetArabicDate2($item->created_at)}}
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
