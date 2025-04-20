@extends('site.layouts.main')
@section('title','قائمة اسعار خدماتى')
@section('content')

    <style>
        .custom-file-label::after {
            left: 0;
            right: unset !important;
        }

        .custom-file {
            margin-bottom: 25px !important
        }

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
            padding: 15px !important;
            vertical-align: middle;
            text-align: center;
        }

        .inbox-head {
            background: none repeat scroll 0 0 #dd9b25;
            border-radius: 0 4px 0 0;
            color: #fff;
            min-height: 60px;
            padding: 10px 20px;
        }

        .avatar {
            width: 50px;
            border-radius: 50%;
        }

        .styled-form input[type="text"], .styled-form select {
            height: 40px;
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
                                    <h3> اسعار خدماتى </h3>
                                </div>

                                <div class="styled-form register-form" style="margin-top: 25px;">

                                    <form id="make-service-request">
                                        @csrf

                                        <input type="hidden" value="{{auth()->guard('lawyer')->user()->id}}"
                                               name="lawyer_id">


                                        <div class="form-group form-md-line-input mt-repeater">
                                            <div data-repeater-list="group-c" id='all'>
                                                @if(!$lawyerServicesPrices->isEmpty())
                                                    @foreach($lawyerServicesPrices as $price)
                                                        <div data-repeater-item="" class="mt-repeater-item">
                                                            <div class="mt-repeater-row">

                                                                <div class="form-group m-form__group row"
                                                                     style="margin-bottom: 15px;">

                                                                    <div class="select col-lg-5 m-form__group-sub">
                                                                        <select name="service" class="form-control">
                                                                            <option value=""> الخدمة</option>
                                                                            @foreach($services as $service)
                                                                                <option {{$service->id == $price->service_id ? "selected":"" }} value="{{ $service->id }}">
                                                                                    {{ $service->title }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="select col-lg-4 m-form__group-sub">
                                                                        <input type="text" value="{{ $price->price }}"
                                                                               name="service_price" placeholder="السعر"
                                                                               class="form-control service-price ">
                                                                        <p class="price-message"></p>
                                                                    </div>

                                                                    <div class="col-md-1 dlt">
                                                                        <a href="javascript:" style="margin-top: 0px;"
                                                                           data-repeater-delete=""
                                                                           class="btn btn-danger mt-repeater-delete">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <br>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div data-repeater-item="" class="mt-repeater-item">
                                                        <div class="mt-repeater-row">
                                                            <div class="form-group m-form__group row"
                                                                 style="margin-bottom: 15px;">
                                                                <div class="select col-lg-5 m-form__group-sub">
                                                                    <label>الخدمة</label>
                                                                    <select name="service" class="form-control">
                                                                        @foreach($services as $service)
                                                                            <option
                                                                                value="{{ $service->id }}"> {{ $service->title }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="select col-lg-4 m-form__group-sub">
                                                                    <label>السعر</label>
                                                                    <input type="text" name="service_price"
                                                                           placeholder="السعر"
                                                                           class="form-control service-price">
                                                                    <p class="price-message"></p>
                                                                </div>
                                                                <div class="col-md-1 dlt">
                                                                    <a href="javascript:" style="margin-top: 0px;"
                                                                       data-repeater-delete=""
                                                                       class="btn btn-danger mt-repeater-delete">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group m-form__group ">
                                                <a href="javascript:" data-repeater-create=""
                                                   class="btn btn-info mt-repeater-add">
                                                    <i class="fa fa-plus"></i> اضف سعر خدمة جديد
                                                </a>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="clearfix">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="theme-btn btn-style-three"
                                                        id="confirm_price_btn"><span class="txt"> تأكيد الاسعار </span>
                                                </button>

                                                <span style="display: none;" id="AjaxLoader" class="">
                                    <img src="{{asset('site/images/loader2.gif')}}">
                                </span>
                                            </div>
                                        </div>

                                        <div style="display: none !important"
                                             class="m-alert m-alert--outline alert alert-success  show"
                                             id="mail-success-div">
                                            </button>
                                            <strong>تنبيه!</strong>
                                            تم تسجيل قائمة اسعار الخدمات الخاصة بك .
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </section>



    <script>
        $(document).ready(function () {
            $('.service-price').on('keypress', function () {
                var ele = $(this);
                var price = $(this).val();
                var servID = $(this).parents('div.select').prev('div.select').find('select option:selected').val();

                $.ajax({
                    url: "{{route('site.lawyer.services.prices.check')}}",
                    dataType: 'json',
                    type: 'POST',
                    data: {_token: $('meta[name="csrf-token"]').attr('content'), price: price, servID: servID},

                    success: function (data) {
                        if (data.success == 0) {
                            ele.next('p.price-message').html("سعر الخدمة يجب ان يكون اكبر من " + data.min_price + " واقل من " + data.max_price + " ").css({
                                "color": "red",
                                "font-size": "12px",
                                "text-align": "center"
                            });
                        } else {
                            ele.next('p.price-message').text("");
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });

            });


            $('#make-service-request').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    url: "{{route('site.lawyer.services.prices.store')}}",
                    type: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $("#AjaxLoader").show();
                        $("#confirm_price_btn").attr('disabled', 'disabled');
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحفظ !",
                            text: " تم حفظ المعلومات  بنجاح ,وتم تجاوز اسعار الخدمات التي لا تنطبق عليها شروط السعر الاقصى والادنى. ",
                            confirmButtonText: 'موافق',
                            customClass: {confirmButton: "btn btn-success"}
                        }).then(function () {
                            location.reload();
                        })


                    },
                    error: function (error) {
                        Swal.fire({
                            title: "مشكلة !",
                            text: " هناك مشكلة في النظام يرجى مراجعة مدير النظام !",
                            icon: "error",
                            confirmButtonText: "موافق",
                            customClass: {confirmButton: "btn btn-primary"},
                            buttonsStyling: !1
                        })
                    }

                });

            });
        });
    </script>

@endsection
