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
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.client_advisory_services_reservations.update')}}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">معلومات العميل</h4>
                                </div>
                                <input type="hidden" name="id" value="{{$reservation->id}}">
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    <div class="row ">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> اسم </label>
                                            <span class="form-control">{{$reservation->client->myname}}</span>

                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الايميل </label>
                                            <span class="form-control">{{$reservation->client->email}}</span>

                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الهاتف </label>
                                            <span class="form-control">{{$reservation->client->mobil}}</span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> النوع </label>
                                            <span class="form-control">{{$reservation->client->Type()}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">معلومات الاستشارة</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    <div class="row ">
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> نوع الاستشارة </label>
                                            <span class="form-control">{{$reservation->service->title}}</span>

                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الخدمة </label>
                                            <span class="form-control">{{$reservation->type->title}}</span>

                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> درجة الاهمية </label>
                                            <span class="form-control">{{is_null($reservation->importanceRel) ? "-" : $reservation->importanceRel->title}}</span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> السعر </label>
                                            <span class="form-control">{{$reservation->price .' ريال'}}</span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> حالة الدفع </label>
                                            <span class="form-control">{{$reservation->paymentStatus() }}</span>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> حالة الرد </label>
                                            <span class="form-control">{{$reservation->replayStatus() }}</span>
                                        </div>
                                        <div class="col-lg-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> محتوى الطلب </label>
                                            <textarea class="form-control" rows="5"
                                                      disabled>{{$reservation->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> حالة الاستشارة</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    <div class="row ">
                                        <div class="col-lg-12 col-sm-6 mb-1">
                                            <label class="form-label"> حالة الاستشارة</label>
{{--                                               @if($reservation->reservation_status == 5)--}}
{{--                                                    <span class="form-control text-center" style="font-weight: bold">تم الرد</span>--}}

{{--                                        @else--}}
                                                    <select class="form-control select2" name="reservation_status"
                                                            id="reservation_status_select">
                                                        <option
                                                            value="1" {{$reservation->reservation_status ==1 ?'selected':''}}>
                                                            مقبول
                                                        </option>
                                                        <option
                                                            {{$reservation->reservation_status ==2 ?'selected':''}} value="2">
                                                            احالة الى مستشار
                                                        </option>
{{--                                                        <option  {{$reservation->reservation_status ==3 ?'selected':''}} value="3"> مقبول  المستشار</option>--}}
                                                        {{--                                                <option  {{$reservation->reservation_status ==4 ?'selected':''}} value="4"> مرفوض من المستشار</option>--}}
                                                        <option
                                                            {{$reservation->reservation_status ==5 ?'selected':''}} value="5">
                                                            اكتمل الرد
                                                        </option>
                                                        <option
                                                            {{$reservation->reservation_status ==6 ?'selected':''}} value="6">
                                                            رفض اداري
                                                        </option>
                                                    </select>

{{--                                            @endif--}}
                                        </div>
                                        <div class="col-lg-12 col-sm-6 mb-1 d-none" id="lawyer_id_div">
                                            <label class="form-label"> المستشارين </label>
                                            <select class="form-control select2" name="lawyer_id"
                                                    id="lawyer_id_select">
                                                <option
                                                    value="">
                                                    اختر مستشار
                                                </option>
                                                @foreach($lawyers as $lawyer)
                                                    <option
                                                        value="{{$lawyer->id}}" {{$lawyer->id ==$reservation->lawyer_id ?'selected':''}}>
                                                        {{$lawyer->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!is_null($reservation->lawyer_id))
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">معلومات المستشار </h4>
                                    </div>
                                    <div class="card-body py-2 my-25">
                                        <!-- form -->
                                        <div class="row ">
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> اسم </label>
                                                <span class="form-control">{{$reservation->lawyer->name}}</span>

                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> الايميل </label>
                                                <span class="form-control">{{$reservation->lawyer->email}}</span>

                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> الهاتف </label>
                                                <span class="form-control">{{$reservation->lawyer->phone}}</span>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> النوع </label>
                                                <span class="form-control">{{$reservation->client->Type()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($reservation->replay_status == 1)
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">الرد على الاستشارة </h4>
                                    </div>
                                    <div class="card-body py-2 my-25">
                                        <!-- form -->
                                        <div class="row ">
                                            <div class="col-lg-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> عنوان الرد </label>
                                                <span class="form-control">{{$reservation->replay_subject}}</span>

                                            </div>
                                            <div class="col-lg-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> محتوى الرد </label>

                                                <textarea class="form-control" rows="5" disabled>{{$reservation->replay_content}}</textarea>

                                            </div>
                                            @if(!is_null($rate))
                                            <div class="col-lg-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName">  تقييم العميل </label>
                                                <br>
                                                <br>
                                                @for($x = 1 ; $x <= $rate->rate ; $x++)
                                                    <img src="{{asset('star.jpg')}}" height="50px" width="50px">
                                                @endfor
                                            </div>
                                            @endif
                                            @if(!is_null($reservation->replay_file))
                                            <div class="col-lg-6 col-sm-6 mb-1">
                                                <a href="{{$reservation->replay_file}}" target="_blank"
                                                   class="btn btn-outline-secondary mt-1">
                                                    ملفات الرد
                                                </a>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
{{--                                @if($reservation->reservation_status !=5)--}}
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
{{--                                @endif--}}
                                <a href="{{route('admin.client_advisory_services_reservations.index')}}" type="reset" class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </a>
                                @if(!is_null($reservation->file))
                                    <a href="{{$reservation->file}}" target="_blank"
                                       class="btn btn-outline-secondary mt-1">
                                        الملفات
                                    </a>
                                @endif
                            </div>
                        </form>
                        <!--/ form -->
                    </div>

                </div>


            </div>
        </div>
    </div>

    <!-- END: Content-->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            let reservation_status_val = '{{$reservation->reservation_status}}';
            let lawyer_id_div = $('#lawyer_id_div');
            if (reservation_status_val == 2) {
                if (lawyer_id_div.hasClass('d-none')) {
                    lawyer_id_div.removeClass('d-none');
                } else {
                    lawyer_id_div.addClass('d-none');
                }
            } else {
                if (lawyer_id_div.hasClass('d-none') == false) {
                    lawyer_id_div.addClass('d-none');
                }
            }


        });

        $('#reservation_status_select').on('change', function () {
            let reservation_status_val = $(this).val();
            let lawyer_id_div = $('#lawyer_id_div');
            if (reservation_status_val == 2) {
                if (lawyer_id_div.hasClass('d-none')) {
                    lawyer_id_div.removeClass('d-none');
                } else {
                    lawyer_id_div.addClass('d-none');
                }
            } else {
                if (lawyer_id_div.hasClass('d-none') == false) {
                    lawyer_id_div.addClass('d-none');
                }
            }
        })

    </script>

@endsection
