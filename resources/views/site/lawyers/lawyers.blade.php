@extends('site.layouts.main')
@section('title',$Lawyer->name)
@section('content')

    <style>
        .name_lawyer h2 {
            font-size: 25px
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

        .br-widget {
            padding-top: 25px;
            text-align: center;
        }

        .br-theme-css-stars .br-widget a {
            float: none !important;
        }

        .special {
            position: absolute !important;
            top: 10px;
            left: 10px;
            width: 90px !important;
            height: 90px !important;
        }

        .name_lawyer a {
            padding: 3px 8px;
            font-size: 10px;
        }
    </style>
    <!-- Page Title -->
    <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
        <div class="auto-container">
            <div class="side-icon">
                <img src="{{asset('site/images/logo.png')}}" alt=""/>
            </div>
            <h2>{{$Lawyer->name}}</h2>
            @include('site.website_main_banner')
            @if(auth()->guard('client')->check() == false)
                <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white">
                    <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً</div>
                </a>
            @endif
        </div>
    </section>
    <!-- End Page Title -->

    <!-- Team Detail Section -->
    <section class="team-detail-section">
        <div class="auto-container">
            <div class="upper-box">
                <div class="row clearfix">
                    <!-- Image Column -->
                    <div class="image-column col-lg-3 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="image">
                                <img src="{{$Lawyer->photo}}" alt=""/>
                                @if($Lawyer->special == 1)
                                    <img class="special" src="{{asset('site/images/special.png')}}">
                                @endif
                            </div>
                            @if(auth()->guard('client')->check())
                            @if(auth()->guard('client')->user()->id)
                                <!-- 5 Star Rating -->
                                <select name="star_rating_option" class="rating" id='star_rating_{{$Lawyer->id}}'
                                        data-id='rating_{{$Lawyer->id}}'>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            @endif
                            @endif
                        </div>
                    </div>
                    <!-- Content Column -->
                    <div class="content-column col-lg-9 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="title"></div>
                            <div class="name_lawyer">

                                <div class="col-lg-5 col-md-12 col-sm-12">
                                    <h2>{{$Lawyer->name}}</h2>
                                </div>
                                <div class="col-lg-7 col-md-12 col-sm-12 text-left">
                                    {{--                                    @if(auth()->guard('client')->check())--}}
                                    <a title="طلب استشارة من المحامى"
                                       href="{{route('site.client.advisory-services.create',$Lawyer->id)  }}"
                                       class="theme-btn btn-style-three">
                                            <span class="txt"><i
                                                    class="fa fa-user"></i> طلب استشارة</span>
                                    </a>
                                    @if(auth()->guard('client')->check())

                                    <a title="تقديم شكوى فى المحامى" href="#" id="make-complaint-btn"
                                       class="theme-btn btn-style-three">
                                            <span class="txt">
                                                <i class="fa fa-microphone"></i>
                                                تقديم شكوى
                                            </span>
                                    </a>
                                    @endif
                                    {{--                                        <a title="مراسلة المحامى" href="#" id="send-message"--}}
                                    {{--                                           class="theme-btn btn-style-three"><span class="txt"><i--}}
                                    {{--                                                    class="fa fa-envelope"></i> مراسلة </span></a>--}}

                                    <a title="اسعار خدمات المحامى"
                                       id="services-prices"
                                       class="theme-btn btn-style-three"><span class="txt"><i
                                                class="fa fa-money"></i> طلب خدمة    </span>
                                    </a>
                                    {{--                                    @endif--}}
                                </div>

                            </div>

                            <div class="designation">{{$Lawyer->about}}</div>
                            <ul class="attorney-contact-info">

                                <li>
									<span>
										الدولة :
									</span> {{$country}}
                                </li>

                                <li>
									<span>
										المدينة :
									</span> {{ GetName('cities', 'title', 'id', $Lawyer->city)}}
                                </li>
                                <li>
									<span>
										الجنسية :
									</span> {{$nationality}}
                                </li>
                                <li>
									<span>
										الدرجة العلمية :
									</span> {{ ($Lawyer->degree) ? GetName('degrees', 'title', 'id', $Lawyer->degree) : "غير محددة"}}
                                </li>
                                {{--                                @if(setting('site.allow_lawyers_details') == 1)--}}
                                <li><span> الجوال: </span><a href="tel:{{$Lawyer->phone}}">{{$Lawyer->phone}}</a>
                                </li>
                                <li>
                                    <span>البريد الإلكتروني : </span><a
                                        href="mailto:{{$Lawyer->email}}">{{$Lawyer->email}}</a></li>
                                {{--                                @endif--}}
                            </ul>
                            <h3 class="mt-4">التخصصات :
                            </h3>
                            <ul class="tag-list clearfix">
                                @foreach($DigitalGuideCategories  as $DigitalGuideCategory)
                                    <li><a>{{$DigitalGuideCategory->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="default-section" style="background-image:url({{asset('site/images/background/1.jpg')}})">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Form Column -->
                <div class="form-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title light">
                            <div class="title">تذكرة طلب
                            </div>
                            <h2>بادر بحجز مكتبك الالكتروني فورا
                            </h2>
                        </div>

                        <!-- Case Form -->
                        <div class="case-form">

                            <div class="alert alert-success alert-block" style="display: none;">
                                <button style="float: left;padding: 0px;" type="button" class="close"
                                        data-dismiss="alert">×
                                </button>
                                <strong class="success-msg"></strong>
                            </div>

                            <form id="reservations">
                                @csrf
                                <div class="form-group">
                                    <fieldset>
                                        <label></label>
                                        <input type="text" name="name" id="name" placeholder="الاسم بالكامل">
                                        <span class="icon flaticon-user"></span>
                                    </fieldset>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text name_err"></span>
                                </div>

                                <div class="form-group">
                                    <fieldset>
                                        <label></label>
                                        <input type="email" name="email" id="email" placeholder="البريد الالكتروني">
                                        <span class="icon flaticon-email-2"></span>
                                    </fieldset>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text email_err"></span>
                                </div>

                                <div class="form-group">
                                    <fieldset>
                                        <select name="case_type" class="custom-select-box" id="case_type">
                                            <option value=""> اختر</option>
                                            @foreach(GetCaseTypes() as $type)
                                                <option value="{{ $type->id }}"> {{ $type->title }} </option>
                                            @endforeach

                                        </select>
                                    </fieldset>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text case_type_err"></span>
                                </div>

                                <div class="form-group">
                                    <fieldset>
                                        <textarea id="reservation_message" name="reservation_message"
                                                  placeholder="رسالتك"></textarea>
                                        <span class="icon flaticon-edit"></span>
                                    </fieldset>
                                    <span style="display: block;text-align: right;"
                                          class="text-danger error-text reservation_message_err"></span>
                                </div>

                                <div class="form-group">
                                    <button class="theme-btn btn-style-one reservation-submit" type="submit"
                                            name="submit-form"><span class="txt">ارسال</span></button>
                                </div>

                            </form>
                        </div>


                    </div>
                </div>
                <!-- Counter Column -->
                <div class="counter-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title light">
                            <div class="title">إنجازاتنا بالأرقام​​
                            </div>
                            <h2>الخسارة ليست ضمن خياراتنا
                            </h2>
                        </div>

                        <!-- Fact Counter -->
                        <div class="fact-counter">
                            <div class="row clearfix">

                                <!-- Column -->
                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12">
                                    <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                        <div class="content">
                                            <div class="icon flaticon-auction-1"></div>
                                            <div class="count-outer count-box">
                                                <span class="count-text" data-speed="3500" data-stop="987">0</span>+
                                            </div>
                                            <div class="counter-title">قضية جنائية حلها</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column -->
                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12">
                                    <div class="inner wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1500ms">
                                        <div class="content">
                                            <div class="icon flaticon-justice-scale"></div>
                                            <div class="count-outer count-box">
                                                <span class="count-text" data-speed="3000" data-stop="6598">0</span>+
                                            </div>
                                            <div class="counter-title">مساحة تجارية</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column -->
                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12">
                                    <div class="inner wow fadeInLeft" data-wow-delay="600ms" data-wow-duration="1500ms">
                                        <div class="content">
                                            <div class="icon flaticon-swear"></div>
                                            <div class="count-outer count-box">
                                                <span class="count-text" data-speed="3000" data-stop="5646">0</span>+
                                            </div>
                                            <div class="counter-title">المحامون العاملون</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column -->
                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12">
                                    <div class="inner wow fadeInLeft" data-wow-delay="600ms" data-wow-duration="1500ms">
                                        <div class="content">
                                            <div class="icon flaticon-laurel-wreath"></div>
                                            <div class="count-outer count-box">
                                                <span class="count-text" data-speed="3000" data-stop="1111">0</span>+
                                            </div>
                                            <div class="counter-title">شركة مواقع عالمية</div>
                                        </div>
                                    </div>
                                </div>

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
                    <h2> ارسال رساله للمحامى </h2>
                </div>
                <div class="modal-body text-right">
                    <div style="display: none !important" class="m-alert m-alert--outline alert alert-success  show"
                         id="mail-success-div">
                        </button>
                        <strong>تنبيه!</strong> تم ارسال الرساله بنجاح للمحامى وسيقوم بالتواصل معكم..
                    </div>

                    <form id="sendLawyerMailForm">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="lawyerID" value="{{ $Lawyer->id }}" class="form-control"
                                   id="lawyerID">

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

    <div id="make-complaint-modal" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> تقديم شكوى على المحامى </h2>
                </div>
                <form id="makeComplaintForm" action="{{route('site.client.complains.store')}}">

                    <div class="modal-body text-right">

                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="lawyer_id" value="{{ $Lawyer->id }}" class="form-control"
                                   id="lawyer_id">
                            <div id="reason">
                                <label> نص الشكوى :</label>
                                <textarea rows="6" cols="5" type="text" name="complaint_body"
                                          class="form-control "></textarea>
                                <span style="display: block;text-align: right;"
                                      class="text-danger error-text make_complaint_complaint_body_error"></span>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">تقديم</button>
                        <button type="button" class="btn btn-danger" id="close-complaint-modal-btn"
                                data-dismiss="modal">إغــلاق
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>




    <div id="servicesPrices" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2><i class="fa fa-money"></i> قائمة اسعار خدمات المحامى </h2>
                </div>
                <div class="modal-body text-right">

                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"> اسم الخدمة</th>
                            <th scope="col">السعر</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(!$lawyerServicesPrices->isEmpty())
                            @foreach($lawyerServicesPrices as $service)
                                <tr>
                                    <th scope="row">{{ $service->id }}</th>
                                    <td>{{ $service->service->title }}</td>
                                    <td>{{ $service->price }} ر.س</td>
                                    <td>
                                        @if(auth()->guard('client')->check())
                                            <a style="padding: 3px 8px;" title="طلب خدمة من المحامى"
                                               href="{{route('site.client.service-request.createWithLawyer',[$service->service->id,$Lawyer->id]) }}"
                                               class="theme-btn btn-style-three">
                                            <span style="font-size: 10px" class="txt">
                                                <i class="fa fa-cog"></i> طلب الخدمة </span>
                                            </a>
                                        @else
                                            <a style="padding: 3px 8px;" title="طلب خدمة من المحامى"
                                               href="{{route('site.client.service-request.create-visitor-service',[$service->service->id]) }}"
                                               class="theme-btn btn-style-three">
                                            <span style="font-size: 10px" class="txt">
                                                <i class="fa fa-cog"></i> طلب الخدمة </span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else

                        @endif

                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>

@endsection

@section('site_scripts')
    <script type='text/javascript'>
        $(document).ready(function () {

            $('#star_rating_<?php echo $Lawyer->id; ?>').barrating('set', <?= ($rating) ? $rating->rating : "0";?>);
        });

        $(function () {
            $('.rating').barrating({
                //theme: 'bars-square',
                theme: 'css-stars',
                initialRating: <?= ($rating) ? $rating->rating : "0";?>,
                onSelect: function (value, text, event) {

                    var el = this;
                    var el_id = el.$elem.data('id');
                    if (typeof (event) !== 'undefined') {
                        var split_id = el_id.split("_");
                        var product_id = split_id[1];
                        $.ajax({
                            url: "#",
                            type: 'post',
                            data: {
                                lawyer_id: product_id,
                                rating: value,
                                _token: "{{ csrf_token() }} "
                            },
                            dataType: 'json',
                            success: function (data) {
                                var average = data['numRating'];
                                $('#numeric_rating_' + product_id).text(average);
                            }
                        });
                    }
                }
            });
        });

        $('#services-prices').on('click', function (e) {
            e.preventDefault();
            $('#servicesPrices').modal('show');
        });
        $('#make-complaint-btn').on('click', function (e) {
            e.preventDefault();
            $('#make-complaint-modal').modal('show');
        });
        $('#close-complaint-modal-btn').on('click', function (e) {
            e.preventDefault();
            $('#make-complaint-modal').modal('hide');
        });

        $('#makeComplaintForm').on('submit', function (event) {
            event.preventDefault();
            let actionUrl = $(this).attr('action');
            let formData = getFormInputs($(this))
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,

                success: function (response) {
                    if (response.status) {
                        $('#make-complaint-modal').modal('hide');

                        Swal.fire(
                            'تهانينا !',
                            response.msg,
                            'success'
                        ).then(function () {
                            location.reload();
                        })
                    }
                },
                error: function (error) {
                    $('#make-complaint-modal').modal('show');
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.make_complaint_' + key + '_error').text(value);
                    });
                }

            });
        });
    </script>

@endsection
