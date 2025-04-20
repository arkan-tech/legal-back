@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            @if (Session::get('error_adv'))
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">   خطأ في البيانات</h4>
                    <div class="alert-body">
                        <div class="">
                            <ul>
                                <li>{{ Session::get('error_adv') }}</li>
                            </ul>
                        </div>
                    </div>

                </div>
            @endif

            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.clients.service-request.update')}}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> تعديل معلومات الطلب</h4>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="id" id="id" value="{{$item->id}}">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> العميل : </label>
                                            <div class="mb-1">
                                                <span id="client_name"
                                                      class="form-control">{{$item->client->myname}}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label> الجوال : </label>
                                            <div class="mb-1">
                                                <span id="client_phone"
                                                      class="form-control">{{$item->client->mobil}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> الايميل : </label>
                                            <div class="mb-1">
                                                <span id="client_phone"
                                                      class="form-control">{{$item->client->email}}</span>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <label> الخدمة : </label>
                                            <div class="mb-1">
                                                <span id="client_phone"
                                                      class="form-control">{{$item->type->title}}</span>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label> مستوى الطلب : </label>
                                            <div class="mb-1">
                                                <span id="client_phone"
                                                      class="form-control">{{$item->priority==1?'مرتبط بموعد':'عاجل جداً'}}</span>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label> وصف الطلب : </label>
                                            <div class="mb-1">
                                                <textarea id="description" rows="5" class="form-control"
                                                          disabled>{{$item->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> حالة الدفع: </label>
                                            <div class="mb-1">
                                                <select class="form-control select2"
                                                        name="payment_status" required>
                                                    <option value="1" {{$item->transaction_complete ==1?'selected':''}}>
                                                        تم الدفع
                                                    </option>
                                                    <option value="0" {{$item->transaction_complete ==0?'selected':''}}>
                                                  غير مدفوع
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-none" id="price">
                                            <label> السعر : </label>
                                            <div class="mb-1">
                                                <input type="number" class="form-control" id="price_input" name="price"
                                                       value="{{$item->price}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label> حالة التذكرة: </label>
                                            <div class="mb-1">
                                                <select class="form-control select2"
                                                        name="referral_status" required>
                                                    <option value="1" {{$item->referral_status ==1?'selected':''}}>   قيد الدراسة</option>
                                                    <option value="2" {{$item->referral_status ==2?'selected':''}}> انتظار</option>
                                                    <option value="3" {{$item->referral_status ==3?'selected':''}}> اكتمال الطلب</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> مكان التذكرة: </label>
                                            <div class="mb-1">
                                                <select class="form-control select2" id="for_admin_select"
                                                        name="for_admin" required>
                                                    <option value="1" {{$item->for_admin ==1?'selected':''}}> الادمن
                                                    </option>
                                                    <option value="2" {{$item->for_admin ==2?'selected':''}}>هيئة
                                                        استشارية
                                                    </option>
                                                    <option value="3" {{$item->for_admin == 3?'selected':''}}>
                                                        مستشار
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-none" id="advisory_div">
                                            <label> الهيئات : </label>
                                            <div class="mb-1">
                                                <select class="form-control select2" id="advisory_select"
                                                        name="advisory_id">
                                                    @include('admin.clients.service-request.advisory-select');
                                                </select>
                                                @error('advisory_id')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-none" id="lawyer_div">
                                            <label> المستشارين : </label>
                                            <div class="mb-1">
                                                <select class="form-control select2" id="lawyer_select"
                                                        name="lawyer_id">
                                                    @include('admin.clients.service-request.lawyers-select', array('item'=> $item))
                                                    ;
                                                </select>
                                                @error('lawyer_id')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-none" id="all_lawyers_div">
                                            <label> المستشارين : </label>
                                            <div class="mb-1">
                                                <select class="form-control select2" id="all_lawyers_select"
                                                        name="direct_lawyer_id">
                                                    @forelse($all_lawyers as $lawyer)
                                                        <option
                                                            value="{{$lawyer->id}}" {{$item->lawyer_id == $lawyer->id ?'selected':''}}>{{$lawyer->name}} </option>
                                                    @empty
                                                        <option value="">-- لا يوجد مستشارين --</option>
                                                    @endforelse

                                                </select>
                                                @error('direct_lawyer_id')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
                                @if(!is_null($item->file))
                                    <a download="{{$item->file}}" href="{{$item->file}}"
                                       class="btn btn-primary mt-1 me-1">تنزيل المرفق
                                    </a>
                                    <a href="{{$item->file}}" target="_blank"
                                       class="btn btn-primary mt-1 me-1">عرض المرفق
                                    </a>
                                @endif
                                <a href="{{route('admin.clients.service-request.index')}}"  class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </a>
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
            let payment_status = '{{$item->payment_status}}';
            let for_admin = '{{$item->for_admin}}';
            var lawyer_div = $('#lawyer_div');
            var all_lawyers_div = $('#all_lawyers_div');
            var advisory_div = $('#advisory_div');

            if (payment_status == 1) {
                $('#price').removeClass('d-none');
                $('#price_input').attr('required', 'required');

            } else {
                if ($('#price').hasClass('d-none') == false) {
                    $('#price').addClass('d-none');

                }
            }
            if (for_admin == 2) {
                if (advisory_div.hasClass('d-none')) {
                    advisory_div.removeClass('d-none')
                }
                if (lawyer_div.hasClass('d-none')) {
                    lawyer_div.removeClass('d-none')
                }
            } else if(for_admin ==3) {
                if (!advisory_div.hasClass('d-none')) {
                    advisory_div.addClass('d-none')
                }
                if (!lawyer_div.hasClass('d-none')) {
                    lawyer_div.addClass('d-none')
                }
                if (all_lawyers_div.hasClass('d-none')) {
                    all_lawyers_div.removeClass('d-none')
                }
            }else{
                if (!advisory_div.hasClass('d-none')) {
                    advisory_div.addClass('d-none')
                }
                if (!lawyer_div.hasClass('d-none')) {
                    lawyer_div.addClass('d-none')
                }
                if (!all_lawyers_div.hasClass('d-none')) {
                    all_lawyers_div.addClass('d-none')
                }
            }
        });
        $('#payment_status').on('change', function () {
            let value = $(this).val();
            if (value == 1) {
                $('#price').removeClass('d-none');
                $('#price_input').attr('required', 'required');
            } else {
                if ($('#price').hasClass('d-none') == false) {
                    $('#price').addClass('d-none');
                    $('#price_input').removeAttr('required');
                }
            }
        });


        $('#for_admin_select').on('change', function (e) {
            let value = $(this).val();
            var lawyer_div = $('#lawyer_div');
            var advisory_div = $('#advisory_div');
            let all_lawyers_div = $('#all_lawyers_div');
            if (value == 2) {
                if (advisory_div.hasClass('d-none')) {
                    advisory_div.removeClass('d-none')
                    $('#advisory_select').attr('required', 'required');
                    $('#lawyer_select').attr('required', 'required');
                }
                if (lawyer_div.hasClass('d-none')) {
                    lawyer_div.removeClass('d-none');
                }
                if (!all_lawyers_div.hasClass('d-none')) {
                    all_lawyers_div.addClass('d-none');
                }
            } else if(value == 3) {
                if (!advisory_div.hasClass('d-none')) {
                    advisory_div.addClass('d-none');
                }
                if (!lawyer_div.hasClass('d-none')) {
                    lawyer_div.addClass('d-none')
                }
                if (all_lawyers_div.hasClass('d-none')) {
                    all_lawyers_div.removeClass('d-none');
                }
            }else {
                if (!advisory_div.hasClass('d-none')) {
                    advisory_div.addClass('d-none');
                }
                if (!lawyer_div.hasClass('d-none')) {
                    lawyer_div.addClass('d-none')
                }
                if (!all_lawyers_div.hasClass('d-none')) {
                    all_lawyers_div.addClass('d-none')
                }
            }


        });

        $('#advisory_select').on('change', function () {
            let advisory_id = $(this).val();
            let item_id = '{{$item->id}}'
            let actionUrl = '{{route('admin.clients.service-request.get-lawyers-base-advisory-id')}}' + '/' + advisory_id + '/' + item_id;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#lawyer_select').html(response.items_html);
                }

            });


        });
    </script>
@endsection
