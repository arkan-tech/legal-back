@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->

                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">معلومات مقدم الخدمة</h4>
                            </div>
                            <div class="card-body py-2 my-25">
                                <!-- form -->
                                <div class="row ">
                                    <div class="col-lg-6 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName">  الاسم </label>
                                        <span class="form-control">{{$item->lawyer->name }}</span>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName"> الايميل </label>
                                        <span class="form-control">{{$item->lawyer->email}}</span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName"> الجوال </label>
                                        <span class="form-control">{{$item->lawyer->phone }}</span>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName"> الجنسية </label>
                                        <span class="form-control">{{$item->lawyer->nationality_rel->name }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h4 class="card-title">معلومات العميل</h4>
                            </div>
                            <div class="card-body py-2 my-25">
                                <!-- form -->
                                <div class="row ">
                                    <div class="col-lg-6 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName">  الاسم </label>
                                        <span class="form-control">{{$item->client->myname }}</span>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName"> الايميل </label>
                                        <span class="form-control">{{$item->client->email}}</span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6 col-sm-6 mb-1">
                                        <label class="form-label" for="accountFirstName"> الجوال </label>
                                        <span class="form-control">{{$item->client->mobil }}</span>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">معلومات الموعد</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    <div class="row ">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> مستوى الطلب </label>
                                            <span class="form-control">{{$item->importance->title }}</span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الخدمة </label>
                                            <span class="form-control">{{$item->service->title}}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> التاريخ </label>
                                            <span class="form-control">{{$item->date->day_name }}</span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الوقت </label>
                                            <span
                                                class="form-control">{{$item->time->time_from.' :'.' '.$item->time->time_to }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> محتوى الطلب </label>
                                            <textarea cols="5" class="form-control"
                                                      disabled>{{$item->description}}</textarea>
                                        </div>
                                    </div>
                                    @if(!is_null($item->file))
                                        <div class="row mt-3">
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <a href="{{$item->file}}" target="_blank" class="btn btn-secondary">مرفق
                                                    العميل</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> حالة الموعد </label>
                                            <select class="form-control" disabled>
                                                <option  {{$item->status==0?'selected':''}}> انتظار</option>
                                                <option  {{$item->status==1?'selected':''}}> مكتمل</option>
                                                <option {{$item->status==2?'selected':''}}> ملغي</option>
                                                <option {{$item->status==3?'selected':''}}> مشكلة في الدفع</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> حالة الدفع </label>
                                            <select class="form-control" disabled>
                                                <option value="1" {{$item->status==1?'selected':''}}> مدفوع</option>
                                                <option value="0" {{$item->status==0?'selected':''}}> غير مدفوع</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> السعر </label>
                                            <span class="form-control">{{$item->price .'ريال سعودي'}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($item->complete_status == 1)
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title"> الرد على الطلب</h4>
                                    </div>
                                    <div class="card-body py-2 my-25">
                                        <!-- form  -->
                                        <div class="row mt-3">
                                            <div class="col-lg-12 col-sm-6 mb-1 ">
                                                <label class="form-label" for="accountFirstName"> محتوى الرد </label>
                                                <textarea cols="5" class="form-control"
                                                          disabled>{{$item->replay}}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> تاريخ الرد </label>
                                                <span class="form-control">{{$item->replay_date}}</span>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> وقت الرد </label>
                                                <span class="form-control">{{$item->replay_time}}</span>
                                            </div>
                                        </div>
                                        @if(!is_null($item->replay_file))
                                            <div class="row mt-3">
                                                <div class="col-lg-6 col-sm-6 mb-1">
                                                    <a href="{{$item->replay_file}}" target="_blank"
                                                       class="btn btn-secondary">مرفق الرد</a>
                                                </div>
                                            </div>
                                        @endif
                                        @if(!is_null($item->comment))
                                            <div class="row mt-3">
                                                <div class="col-lg-12 col-sm-6 mb-1">
                                                    <label class="form-label" for="accountFirstName"> تعليق
                                                        العميل </label>
                                                    <span class="form-control">{{$item->comment}}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if(!is_null($item->rate))
                                            <div class="col-lg-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> تقييم العميل </label>
                                                <br>
                                                <br>
                                                @for($x = 1 ; $x <= $item->rate ; $x++)
                                                    <img src="{{asset('star.jpg')}}" height="50px" width="50px">
                                                @endfor
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif


                            <div class="col-12">
                                <a href="{{route('admin.clients.lawyer-reservation.index')}}"
                                   class="btn btn-outline-secondary mt-1">رجوع
                                </a>
                            </div>
                        <!--/ form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END: Content-->
@endsection
@section('scripts')

@endsection
