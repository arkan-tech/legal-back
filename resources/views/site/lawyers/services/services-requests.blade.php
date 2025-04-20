@extends('site.layouts.main')
@section('title','طلبات الخدمة')
@section('content')
    <style>
        .apply-office{
            font-family: 'Tajawal Bold';
        }
        .links{
            font-size: 20px;
            font-weight: 700
        }
        .links:hover{
            color: #dd9b25
        }
        a.active{
            color: #000
        }
        .table-inbox {
            border: 1px solid #d3d3d3;
            margin-bottom: 0;
        }
        .table>tbody>tr>td{
            border-top: 1px solid #ddd;
        }
        .table-inbox tr td {
            padding: 10px!important;
            vertical-align: middle;
            text-align: center;
        }
        .inbox-head{
            background: none repeat scroll 0 0 #dd9b25;
            border-radius: 0 4px 0 0;
            color: #fff;
            min-height: 80px;
            padding: 20px;
        }
        .send-mail{
            font-size: 15px;
            padding: 5px;
        }
        .avatar{
            width: 50px;
            border-radius: 50%;
        }
        .modal-header h2{
            font-size: 25px;
        }
        .modal-content{
            direction: rtl;
        }
        #reason label{
            float: right
        }
        .modal-footer a, .modal-footer button{
            padding: 8px 25px;
            margin-left: 15px;
        }
    </style>

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="clearfix row">


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
                                    <h3> طلبات الخدمات </h3>
                                </div>

                                <table class="table table-inbox table-hover">
                                    <tbody>
                                    <tr>
                                        <th>اسم العميل</th>
                                        <th>الخدمة</th>
                                        <th>التفاصيل</th>
                                        <th>حالة الدفع</th>
                                        <th>المرفقات</th>
                                        <th>التاريخ</th>
                                        <th>مراسلة</th>
                                    </tr>
                                    @foreach($lawyer_requests as $request)
                                        <tr data-link="/lawyer-view-sent-message/{{ $request->id }}">
                                            <td class="text-right view-message dont-show">
                                                {{ ($request->client) ? $request->client->myname : "-" }}
                                            </td>
                                            <td class="text-right view-message">
                                                {{ ($request->type) ? $request->type->title : "-" }}
                                            </td>
                                            <td class="text-right view-message">
                                                <div style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;" class="span4 proj-div" data-toggle="modal" data-target="#GSCCModal<?=$request->id;?>">
                                                    عرض التفاصيل
                                                </div>
                                                <div id="GSCCModal<?=$request->id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel"> تفاصيل الطلب </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $request->description }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="inbox-small-cells">
                                                <?php
                                                if ($request->payment_status == 1) {
                                                    echo "مكتمل";
                                                } elseif ($request->payment_status == 2) {
                                                    echo "ملغى";
                                                } elseif ($request->payment_status == 3) {
                                                    echo "مرفوض";
                                                } else {
                                                    echo "غير محدد";
                                                }
                                                ?>
                                            </td>
                                            <td class="inbox-small-cells">
                                    

                                            </td>
                                            <td class="text-center view-message">
                                                <?=GetArabicDate2($request->created_at);?>
                                            </td>
                                            <td class="inbox-small-cells">
                                                <a data-id="{{ $request->client_id }}" title="مراسلة العميل" href="/request-service/1560" class="send-mail theme-btn btn-style-three">
                                                    <span class="txt"><i class="fa fa-envelope"></i> مراسلة العميل </span>
                                                </a>
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
    </section>
    <div id="sendMail" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> ارسال رساله للعميل </h2>
                </div>
                <div class="text-right modal-body">
                    <div style="display: none !important" class="m-alert m-alert--outline alert alert-success show" id="mail-success-div">
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
                                <span style="display: block;text-align: right;color: #dc3545!important" class="mail-text-danger error-text subject_error"></span>
                            </div>

                            <div id="reason">
                                <label> نص الرسالة :</label>
                                <textarea rows="6" cols="5" type="text" name="message" class="form-control message"></textarea>
                                <span style="display: block;text-align: right; color: #dc3545!important" class="mail-text-danger error-text message_error"></span>
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
        $(document).ready(function() {
            $('div').on('click', '.send-mail', function(e)
            {
                e.preventDefault();
                $('#sendMail').modal();

                $('#clientID').val($(this).attr('data-id'));

            });

            $('#sendLawyerMailForm').on('submit', function(event)
            {
                event.preventDefault();
                $.ajax
                (
                    {
                    {{--url: "{{ route('sendclientmail') }}",--}}
                    url: "#",
                    type:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data)
                    {
                        if($.isEmptyObject(data.error))
                        {
                            $("#sendLawyerMailForm")[0].reset();
                            $('.mail-text-danger').hide();
                            $('#clientID').val('');

                            $('#mail-success-div').attr('style', 'display: block !important');
                            setTimeout(function(){
                                $('#mail-success-div').attr('style', 'display: none !important');
                                $('#sendMail').modal('hide');

                                //window.location.reload();
                            }, 3000);

                        }else{
                            $.each(data.error, function( key, value ) {
                                $('.'+key+'_error').text(value);
                            });
                        }

                    }
                });
            });
        });
    </script>



@endsection
