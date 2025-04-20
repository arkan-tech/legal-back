@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 15% ;margin-bottom: 15%">
                <h2> لوحة التحكم </h2>
            </div>
        </div>
        <section class="page-banner">
            <div class="image-layer"></div>
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1></h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a></a></li>
                                <li class="active"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
@section('electronic_office_content')

    <!-- Contact Form Section -->
    <div class="row " style="max-width: 100%">

        <!--Login Form-->
        @include('site.lawyers.electronic_office.dashboard.layouts.side_menue')

        <div class="col-lg-9  mt-3 mb-3">
            <section>
                <div class="auto-container">
                    <div class="row clearfix">
                        <div class="form-column column col-lg-12 col-md-12 col-sm-12">
                            <div class="sec-title">
                                <a style="padding: 15px 30px; float: left; background-color: #dd9b25"
                                   class="theme-btn btn-style-three"
                                   href="{{route('site.lawyer.electronic-office.dashboard.organization-request.create',$id)}}">
                        <span class="txt" style="font-size: 15px;">
                            <i class="fa fa-plus"></i> طلب هيئة استشارية جديد
                        </span>
                                </a>
                                <h5 style="display: inline-block"></h5>
                                <div class="separate"></div>
                            </div>
                            @if(Session::has('success'))
                                <div class="alert alert-primary" role="alert">
                                    <div class="alert-body">
                                        {{Session::get('success')}}
                                    </div>
                                </div>
                            @endif
                            <!--Login Form-->
                            <table class="table table-inbox table-hover text-center">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th> الهيثة الإستشارية</th>
                                    <th>التفاصيل</th>
                                    <th> حالة الدفع</th>
                                    <th>المرفقات</th>
                                    <th>تاريخ الطلب</th>
                                    <th>الحالة</th>
                                    <th>السعر</th>
                                    <th>العمليات</th>
                                </tr>
                                <tbody>
                                @foreach($organizations_request as $request)
                                    <tr>
                                        <td class="view-message text-right">
                                            {{ $request->id }}
                                        </td>
                                        <td class="view-message text-right">
                                            {{ $request->type->title }}
                                        </td>
                                        <td class="view-message text-right">
                                            <div
                                                style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                class="span4 proj-div" data-toggle="modal"
                                                data-target="#GSCCModal{{$request->id}}">
                                                محتوى الطلب
                                            </div>
                                            <div id="GSCCModal{{$request->id}}" class="modal fade" tabindex="-1"
                                                 role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel"> محتوى
                                                                الطلب </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $request->description }}
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
                                            @php
                                                if ($request->payment_status == 1) {
                                                    echo "تم الدفع بنجاح";
                                                } elseif ($request->payment_status == 2) {
                                                    echo "تم الغاء الدفع";
                                                } elseif ($request->payment_status == 3) {
                                                    echo "تم رفض عملية الجفع";
                                                } else {
                                                    echo "غير محدد";
                                                }
                                            @endphp
                                        </td>
                                        <td class="inbox-small-cells text-right">
                                            @if(!is_null($request->file))
                                                <a href="{{ $request->file }}" target="_blank" title="المرفقات">المرفق
                                                </a>
                                            @else
                                                لا يوجد
                                            @endif
                                        </td>
                                        <td class="view-message text-right">
                                            {{GetArabicDate2($request->created_at)}}
                                        </td>
                                        <td>
                                            @if($request->status == 1)
                                                <b style="color:#09bd09">تم القبول</b>
                                            @elseif ($request->status == 2)
                                                <b style='color:red'>تم الرفض</b>
                                            @else
                                                <b style='color:yellow'> انتظار </b>
                                            @endif
                                        </td>
                                        @if($request->status==1)
                                            <td>{{ $request->price.' ريال' }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if($request->status == 1)
                                            <td>
                                                @if($request->payment_status == 0 || $request->payment_status == '')
                                                    {{--                                                    <a style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 15px;" href="{{ route('payorganizationrequestprice', ['id'=> $request->id, 'lawyerID'=> Session::get('loggedInUserID')]) }}" onclick="return confirm('هل انت متأكد انك تريد دفع ثمن الإستشارة ؟')">الدفع</a>--}}
                                                    <a style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 15px;"
                                                       href="#"
                                                       onclick="return confirm('هل انت متأكد انك تريد دفع ثمن الإستشارة ؟')">الدفع</a>
                                                @elseif($request->payment_status == 1)
                                                    <a style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 8px;"
                                                       href="{{route('site.lawyer.electronic-office.dashboard.organization-request.show',['id'=> $request->id ,'electronic_id_code'=>$id ]) }}">

                                                        عرض </a>

                                                @endif
                                            </td>
                                        @else
                                            <td> -</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
