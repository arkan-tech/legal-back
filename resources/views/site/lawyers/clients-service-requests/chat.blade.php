@extends('site.layouts.main')
@section('title', 'الرد على طلب ' )
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

        .chats {
            width: 100%;
        }

        .chats li {
            list-style: none;
            padding: 8px 0 5px;
            margin: 7px auto;
            font-size: 15px;
            width: 50%
        }

        .chats li.in {
            float: right
        }

        .chats li.out {
            float: left
        }

        .chats li .message .body {
            display: block;
        }

        .chats li .message {
            display: block;
            padding: 5px;
            position: relative;

            background: #fbfbfb;
            background-color: rgb(251, 251, 251);
            border-left: 1px solid #eaeaea !important;
            border-right: 1px solid #eaeaea !important;
            padding: 10px !important;
            border-radius: 5px;
        }

        .chats li.in .message {
            text-align: right;
            margin-right: 65px;
            width: 100%
        }

        li.in .message .arrow {
            border-bottom: 8px solid transparent;
            border-top: 8px solid transparent;
            display: block;
            height: 0;
            right: -8px;
            position: absolute;
            top: 15px;
            width: 0;
        }

        .chats li.in .message .arrow {
            border-right: 8px solid #2f8e95;
        }

        li.in .name {
            color: #FB9800 !important;
        }

        .chats li .name {
            font-size: 16px;
            font-weight: 700;
        }

        .chats li.in img.avatar {
            float: right;
            margin-left: 10px;
            height: 45px;
            width: 45px;
        }

        .chats li.out img.avatar {
            float: left;
            margin-right: 10px;
            margin-top: 0px;
            height: 45px;
            width: 45px;
        }

        .chats li.out .name {
            color: #2FADE7 !important;
        }

        .chats li.out .message {
            border-left: 2px solid #b14c4c;
            margin-left: 65px;
            text-align: left;

            /* min-height: 130px; */
            background-color: #dff0d8;
        }

        .chats li.out .message .arrow {
            border-right: 8px solid #2f8e95;
        }

        li.out .message .arrow {
            border-bottom: 8px solid transparent;
            border-top: 8px solid transparent;
            display: block;
            height: 0;
            left: -10px;
            position: absolute;
            top: 15px;
            width: 0;
        }

        .message {
            border: 1px solid #eaeaea;
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
                    <div class="register-form">

                        <div class="row">

                            @include('site.lawyer_right_menu', array('lawyer'=> $lawyer))

                            <div class="col-lg-10 col-md-12 col-sm-12">

                                <div class="row clearfix">

                                    <ul class="chats">

                                        @foreach($replies as $reply)
                                            @if($reply->from_admin == 1 || $reply->from_admin == 3 )
                                                <li class="in">
                                                    <img class="avatar" src="{{asset('uploads/person.png')}}"
                                                         alt=""/>
                                                    <div class="message">
                                                        <span class="arrow"></span>
                                                        @if($reply->from_admin == 1)
                                                            <span class="name"> يمتاز </span>
                                                        @elseif($reply->from_admin == 3)
                                                            <span class="name">
                                                            @php
                                                                $lawyer = \App\Models\Lawyer\Lawyer::where('id',$reply->replay_laywer_id)->first()->name;
                                                                echo $lawyer;
                                                            @endphp
                                                            </span>
                                                        @endif
                                                        <span class="pull-left" style="font-size: 10pt;">
                    {{GetArabicDate2($reply->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($reply->created_at)))}}
                </span>

                                                        <div class="clearfix"></div>
                                                        <span class="body">
                                                             @if(!is_null($reply->file))
                                                                <img src="{{$reply->file}}">
                                                            @endif
                    {{ $reply->replay }}
                </span>
                                                    </div>
                                                </li>
                                                <div class="clearfix"></div>
                                            @else
                                                <li class="out">
                                                    <img class="avatar" src="{{asset('uploads/person.png')}}">
                                                    <div id="" class="message" style="background-color:#dff0d8">
                                                        <span class="arrow"></span>
                                                        <div class="row" style="margin: 0px;">

                                                            <div class="col-lg-12" style="padding-left: 0px;">

                        <span class="pull-right" style="font-size: 10pt;">
                            {{GetArabicDate2($reply->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($reply->created_at)))}}
                        </span>
                                                                <span
                                                                    class="name"> {{$request->client->myname }} </span>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <span class="body">
                                                             @if(!is_null($reply->file))
                                                                <img src="{{$reply->file}}">
                                                            @endif
                    {{ $reply->replay }}
                </span>
                                                    </div>
                                                </li>
                                                <div class="clearfix"></div>
                                            @endif

                                        @endforeach

                                    </ul>
                                </div>

                                <form id="writeReply">
                                    @csrf
                                    <div class="row clearfix">
                                        <input type="hidden" value="{{$id}}" name="client_requests_id">
                                        <input type="hidden" value="3" name="from_admin">
                                        <input type="hidden" value="2" name="from">
                                        <input type="hidden" value="{{auth()->guard('lawyer')->user()->id}}"
                                               name="replay_laywer_id">

                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <textarea class="form-control" cols="5" rows="5" name="replay"
                                                      placeholder="{{$request->status==1?'الرد على الرسالة' :'لقد تم اغلاق التذكرة ويمكنك الان تقييم الخدمة . '}}" {{$request->status ==1?'required':'disabled'}}></textarea>
                                            @if($request->status==1)
                                                <input class="form-control" type="file" name="file"
                                                       accept=".png ,.jpg,.jpeg">
                                            @endif
                                            <span style="display: block;text-align: right;color: #dc3545!important"
                                                  class="mail-text-danger error-text reply_error"></span>
                                        </div>
                                        @if($request->status == 1)
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center form-group">
                                                <button class="theme-btn btn-style-four" type="submit"
                                                        name="submit-form">
                                                    <span class="txt"> ارســـال </span></button>
                                                <span style="display: none;" id="AjaxLoader" class="">
                                                 <img src="{{asset('site/images/loader2.gif')}}">
                                            </span>
                                            </div>
                                        @endif
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
        $('#writeReply').on('submit', function (event) {
            event.preventDefault();
            $.ajax
            ({
                url: "{{route('site.lawyer.clients-service-requests.SendRequestMessage')}}",
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
                    $("#writeReply")[0].reset();
                    $('.text-danger').hide();
                    $("#AjaxLoader").hide();
                    $('.chats').append(data.chats);
                }
            });
        });
    </script>
@endsection
