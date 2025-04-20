@extends('site.layouts.main')
@section('title','طلبات الخدمة')
@section('content')

    <style>


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
            padding: 5px 25px;
            margin-left: 15px;
        }

        .rating {
            display: inline-block;
            position: relative;
            height: 50px;
            line-height: 50px;
            font-size: 50px;
        }

        .rating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            cursor: pointer;
        }

        .rating label:last-child {
            position: static;
        }

        .rating label:nth-child(1) {
            z-index: 5;
        }

        .rating label:nth-child(2) {
            z-index: 4;
        }

        .rating label:nth-child(3) {
            z-index: 3;
        }

        .rating label:nth-child(4) {
            z-index: 2;
        }

        .rating label:nth-child(5) {
            z-index: 1;
        }

        .rating label input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .rating label .icon {
            float: left;
            color: transparent;
        }

        .rating label:last-child .icon {
            color: #000;
        }

        .rating:not(:hover) label input:checked ~ .icon,
        .rating:hover label:hover input ~ .icon {
            color: #09f;
        }

        .rating label input:focus:not(:checked) ~ .icon:last-child {
            color: #000;
            text-shadow: 0 0 5px #09f;
        }
    </style>

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">


                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <a style="padding: 15px 30px; float: left" class="theme-btn btn-style-three"
                           href="{{route('site.client.service-request.create')}}">
                        <span class="txt" style="font-size: 15px">
                            <i class="fa fa-plus"></i> طلب خدمة جديدة
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
                                <h3> طلبات الخدمات </h3>
                            </div>

                            <table class="table table-inbox table-hover text-center">

                                <tr>
                                    <th> #</th>
                                    <th> الخدمة</th>
                                    <th> الاهمية</th>
                                    <th>محتوى الطلب</th>
                                    <th>المرفقات</th>
                                    <th>حالة الرد</th>
                                    <th> السعر</th>
                                    <th>تاريخ الطلب</th>
                                </tr>

                                <tbody>

                                @foreach($client_requests as $request)
                                    <tr class="text-center">

                                        <td class="view-message text-right">
                                            {{  $request->id }}
                                        </td>
                                        <td class="view-message text-right">
                                            {{  $request->type->title }}
                                        </td>
                                        <td class="view-message text-right">
                                            {{$request->priorityRel->title}}
                                        </td>
                                        <td class="view-message text-right">
                                            <div
                                                style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 5px 0px;"
                                                class="span4 proj-div" data-toggle="modal"
                                                data-target="#GSCCModal{{$request->id}}">
                                                عرض محتوى الطلب
                                            </div>
                                            <div id="GSCCModal{{$request->id}}" class="modal fade" tabindex="-1"
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
                                            @if(!is_null($request->file) )
                                                <a href="{{ $request->file }}" target="_blank" title="المرفقات">
                                                    المرفقات
                                                </a>
                                            @else
                                                @php
                                                    echo "لا يوجد";
                                                @endphp
                                            @endif

                                        </td>
                                        <td class="inbox-small-cells">


                                            @if($request->replay_status == 0 )
                                                انتظار
                                            @else
                                                <div
                                                    style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 5px 0px;"
                                                    class="span4 proj-div" data-toggle="modal"
                                                    data-target="#GSCCModalReplay{{$request->id}}">
                                                    عرض الرد
                                                </div>
                                                <div id="GSCCModalReplay{{$request->id}}" class="modal fade"
                                                     tabindex="-1"
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
                                                                        <label> الرد على الاستشارة : </label>
                                                                        <div class="mb-1">
                                                                                <textarea id="replay" rows="5"
                                                                                          class="form-control"
                                                                                          disabled>{{ $request->replay }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label> تاريخ الرد : </label>
                                                                        <div class="mb-1">
                                                                            <span
                                                                                class="form-control">{{$request->replay_date}}</span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label> وقت الرد : </label>
                                                                        <div class="mb-1">
                                                                            <span
                                                                                class="form-control">{{$request->replay_time}}</span>
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
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                        class="btn btn-default btn-secondary"
                                                                        data-dismiss="modal">اغلاق
                                                                </button>
                                                                <button
                                                                    class="btn btn-success" data-toggle="modal"
                                                                    data-target="#GSCCModalRateReplay{{$request->id}}">
                                                                    تقييم
                                                                </button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="GSCCModalRateReplay{{$request->id}}" class="modal fade"
                                                     tabindex="-1"
                                                     role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel"> تقييم
                                                                    الرد</h4>
                                                            </div>

                                                                @if(is_null(GetClientRequestRates($request->id)))
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{route('site.client.service-request.client-rate-replay')}}"
                                                                       id="send_client_rate_replay_form" method="post">
                                                                        <input type="hidden" name="request_id" value="{{$request->id}}">
                                                                        <div class="row ">
                                                                            <div class="col-lg-12">
                                                                                <label> تعليق : </label>
                                                                                <div class="mb-1">
                                                                                <textarea name="comment" rows="5"
                                                                                          class="form-control"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row rating">
                                                                            <label>
                                                                                <input type="radio" name="rate"
                                                                                       value="1"/>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="rate"
                                                                                       value="2"/>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="rate"
                                                                                       value="3"/>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="rate"
                                                                                       value="4"/>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" name="rate"
                                                                                       value="5"/>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                                <span class="icon">★</span>
                                                                            </label>
                                                                        </div>
                                                                        <span style="display: block;text-align: center;"
                                                                              class="text-danger error-text send_client_rate_replay_rate_error"></span>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button id="submit_send_client_rate_replay_form" class="btn btn-success" type="submit">
                                                                        تقييم
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-default btn-secondary"
                                                                            data-dismiss="modal">اغلاق
                                                                    </button>
                                                                </div>
                                                                @else
                                                                <div class="modal-body">
                                                                    @php
                                                                    $requestRate = GetClientRequestRates($request->id);
                                                                    @endphp
                                                                    <div class="row ">
                                                                        <div class="col-lg-12">
                                                                            <label> تعليق : </label>
                                                                            <div class="mb-1">
                                                                                <textarea id="replay" rows="5"
                                                                                          class="form-control" disabled>{{$requestRate->comment}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row rating">
                                                                        <label>
                                                                            @for($i=1;$i<=$requestRate->rate;$i++)
                                                                            <span class="icon" style="color: #09f;">★</span>
                                                                            @endfor
                                                                        </label>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-default btn-secondary"
                                                                            data-dismiss="modal">اغلاق
                                                                    </button>
                                                                </div>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        </td>
                                        <td class="">
                                            {{$request->price .'رس'}}
                                        </td>
                                        <td class="view-message">
                                            {{GetArabicDate2($request->created_at)}}
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

@endsection
@section('site_scripts')
    <script>
        $(':radio').change(function () {
            console.log('New star rating: ' + this.value);
        });
        $('#submit_send_client_rate_replay_form').on('click',function (e){
           let form = $('#send_client_rate_replay_form');
           let FormData = form.serialize();
           let ActionUrl = form.attr('action');
           $.ajax({
               url:ActionUrl,
               type:'post',
               data:FormData,
               success:function (response) {
                    location.reload();
               },
               error:function (error) {
                   $.each(error.responseJSON.errors, function (key, value) {
                       $('.send_client_rate_replay_'+ key + '_error' ).text(value);
                   })
               }

           })
        });

    </script>
@endsection
