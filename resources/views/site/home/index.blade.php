@extends('site.layouts.main')
@section('title', 'يمتاز')
@section('content')
    <!--Main Slider-->
    <section class="main-slider">
        <div class="main-slider-carousel owl-carousel owl-theme">
            <div class="slide" style="background-image:url({{ asset('site/images/slider1.jpg') }})">
                <div class="color-layer"></div>
                <div class="auto-container">
                    <!-- Content boxed -->
                    <div class="content-boxed">
                        <div class="icon-box">
                            <img src="{{ asset('site/images/main-slider/content-icon.png') }}" alt="" />
                        </div>
                        <div class="title">يمتاز - YMTAZ</div>
                        <h1>منصة يمتاز الإلكترونية <br>
                            عالم من المهن الاستشارية
                        </h1>
                        <div class="link-box clearfix">
                            <a class="theme-btn btn-style-one"><span class="txt">طلب استشارة</span></a>
                        </div>
                    </div>
                </div>
                <a target="_blank" href="{{ route('site.lawyer.show.login.form') }}" style="color: white">
                    <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً</div>
                </a>
            </div>
            <div class="slide" style="background-image:url({{ asset('site/images/slider1.jpg') }})">
                <div class="color-layer"></div>
                <div class="auto-container">
                    <!-- Content boxed -->
                    <div class="content-boxed">
                        <div class="icon-box">
                            <img src="{{ asset('site/images/main-slider/content-icon.png') }}" alt="" />
                        </div>
                        <div class="title">يمتاز - YMTAZ
                        </div>
                        <h1>منصة يمتاز الإلكترونية <br>
                            عالم من المهن الاستشارية
                        </h1>
                        <div class="link-box clearfix">
                            <a class="theme-btn btn-style-one"><span class="txt">اللجان المتخصصة</span></a>
                        </div>
                    </div>
                </div>
                <a target="_blank" href="{{ route('site.lawyer.show.login.form') }}" style="color: white">
                    <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً</div>
                </a>
            </div>
        </div>
    </section>
    <!--End Main Slider-->


    <!-- About Section -->
    <section class="about-section">
        <div class="auto-container">
            <div class="row clearfix">

                <!-- Image Column -->
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="pattern-layer"
                            style="background-image:url({{ asset('site/images/background/pattern-2.png') }})"></div>
                        <div class="image wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <img src="{{ asset('uploads/' . $About->Image) }}" alt="" />
                        </div>
                        <div class="image-two wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <img src="{{ asset('uploads/' . $About->second_image) }}" alt="" />
                        </div>
                    </div>
                </div>

                <!-- Content Column -->
                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <div class="title">من نحن</div>
                            <h2>منصة يمتاز الإلكترونية طريقك

                                <br> الي عالم المهن الاستشارية.
                            </h2>
                        </div>
                        <div class="text">
                            {!! $About->details !!}
                        </div>
                        <div class="row">
                            <div class="content-column col-lg-12 col-md-12 col-sm-12">
                                <div class="inner-column">
                                    <div class="blocks-outer">

                                        <!-- Feature Block Two -->
                                        <div class="feature-block-two">
                                            <div class="inner-box">
                                                <div class="icon-box">
                                                    <span class="number">01</span>
                                                    <span class="icon flaticon-strategy"></span>
                                                </div>
                                                <h4>{{ $Mission->Title }}</h4>
                                                <div class="featured-text"> {!! $Mission->details !!} .</div>
                                            </div>
                                        </div>

                                        <!-- Feature Block Two -->
                                        <div class="feature-block-two">
                                            <div class="inner-box">
                                                <div class="icon-box">
                                                    <span class="number">02</span>
                                                    <span class="icon flaticon-handshake"></span>
                                                </div>
                                                <h4>{{ $Vision->Title }}</h4>
                                                <div class="featured-text">{!! $Vision->details !!}</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="law-image">
                <img src="{{ asset('site/images/law.png') }}" alt="" />
            </div>
        </div>
    </section>
    <!-- End About Section -->


    <!-- Services Section -->
    <section class="services-section">
        <div class="auto-container">
            <!-- Sec Title -->
            <div class="sec-title">
                <div class="title">خدماتنا</div>
                <h2>نفتخر بتقديم نطاق واسع من الخدمات القانونية والمهنية بشكل دقيق ومتميز
                </h2>
            </div>
            <div class="three-item-carousel owl-carousel owl-theme">

                @foreach ($services as $service)
                    <!-- Service Block -->
                    <div class="service-block">
                        <div class="inner-box">
                            <div class="image">
                                <a href="{{ route('site.services.show', $service->id) }}"><img
                                        src="{{ asset($service->image) }}" alt="{{ $service->title }}" /></a>
                            </div>
                            <div class="lower-content">
                                <a class="arrow flaticon-next-2"></a>
                                <h4><a href="{{ route('site.services.show', $service->id) }}"> {{ $service->title }} </a>
                                </h4>
                                <div style="height: 110px;overflow: hidden;" class="text"> {{ $service->intro }} </div>
                                <div class="side-icon flaticon-auction"></div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- End Services Section -->


    {{--    <section class="default-section" style="background-image:url({{asset('site/images/background/1.jpg')}})"> --}}
    {{--        <div class="auto-container"> --}}
    {{--            <div class="row clearfix"> --}}

    {{--                <!-- Form Column --> --}}
    {{--                <div class="form-column col-lg-6 col-md-12 col-sm-12"> --}}
    {{--                    <div class="inner-column"> --}}
    {{--                        <!-- Sec Title --> --}}
    {{--                        <div class="sec-title light"> --}}
    {{--                            <div class="title">تذكرة طلب --}}
    {{--                            </div> --}}
    {{--                            <h2>بادر بحجز مكتبك الالكتروني فورا --}}
    {{--                            </h2> --}}
    {{--                        </div> --}}

    {{--                        <!-- Case Form --> --}}
    {{--                        <div class="case-form"> --}}

    {{--                            <div class="alert alert-success alert-block" style="display: none;"> --}}
    {{--                                <button style="float: left;padding: 0px;" type="button" class="close" data-dismiss="alert">×</button> --}}
    {{--                                <strong class="success-msg"></strong> --}}
    {{--                            </div> --}}

    {{--                            <form id="reservations"> --}}
    {{--                                @csrf --}}
    {{--                                <div class="form-group"> --}}
    {{--                                    <fieldset> --}}
    {{--                                        <label></label> --}}
    {{--                                        <input type="text" name="name" id="name" placeholder="الاسم بالكامل"> --}}
    {{--                                        <span class="icon flaticon-user"></span> --}}
    {{--                                    </fieldset> --}}
    {{--                                    <span style="display: block;text-align: right;" class="text-danger error-text name_err"></span> --}}
    {{--                                </div> --}}

    {{--                                <div class="form-group"> --}}
    {{--                                    <fieldset> --}}
    {{--                                        <label></label> --}}
    {{--                                        <input type="email" name="email" id="email" placeholder="البريد الالكتروني" > --}}
    {{--                                        <span class="icon flaticon-email-2"></span> --}}
    {{--                                    </fieldset> --}}
    {{--                                    <span style="display: block;text-align: right;" class="text-danger error-text email_err"></span> --}}
    {{--                                </div> --}}

    {{--                                <div class="form-group"> --}}
    {{--                                    <fieldset> --}}
    {{--                                        <select name="case_type" class="custom-select-box" id="case_type"> --}}
    {{--                                            <option value=""> اختر </option> --}}
    {{--                                            @foreach (GetCaseTypes() as $type) --}}
    {{--                                                <option value="{{ $type->id }}"> {{ $type->title }} </option> --}}
    {{--                                            @endforeach --}}

    {{--                                        </select> --}}
    {{--                                    </fieldset> --}}
    {{--                                    <span style="display: block;text-align: right;" class="text-danger error-text case_type_err"></span> --}}
    {{--                                </div> --}}

    {{--                                <div class="form-group"> --}}
    {{--                                    <fieldset> --}}
    {{--                                        <textarea id="reservation_message" name="reservation_message" placeholder="رسالتك"></textarea> --}}
    {{--                                        <span class="icon flaticon-edit"></span> --}}
    {{--                                    </fieldset> --}}
    {{--                                    <span style="display: block;text-align: right;" class="text-danger error-text reservation_message_err"></span> --}}
    {{--                                </div> --}}

    {{--                                <div class="form-group"> --}}
    {{--                                    <button class="theme-btn btn-style-one reservation-submit" type="submit" name="submit-form"><span class="txt">ارسال</span></button> --}}
    {{--                                </div> --}}

    {{--                            </form> --}}
    {{--                        </div> --}}



    {{--                    </div> --}}
    {{--                </div> --}}
    {{--                <!-- Counter Column --> --}}
    {{--                <div class="counter-column col-lg-6 col-md-12 col-sm-12"> --}}
    {{--                    <div class="inner-column"> --}}
    {{--                        <!-- Sec Title --> --}}
    {{--                        <div class="sec-title light"> --}}
    {{--                            <div class="title">إنجازاتنا بالأرقام​​ --}}
    {{--                            </div> --}}
    {{--                            <h2>الخسارة ليست ضمن خياراتنا --}}
    {{--                            </h2> --}}
    {{--                        </div> --}}

    {{--                        <!-- Fact Counter --> --}}
    {{--                        <div class="fact-counter"> --}}
    {{--                            <div class="row clearfix"> --}}

    {{--                                <!-- Column --> --}}
    {{--                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12"> --}}
    {{--                                    <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms"> --}}
    {{--                                        <div class="content"> --}}
    {{--                                            <div class="icon flaticon-auction-1"></div> --}}
    {{--                                            <div class="count-outer count-box"> --}}
    {{--                                                <span class="count-text" data-speed="3500" data-stop="987">0</span>+ --}}
    {{--                                            </div> --}}
    {{--                                            <div class="counter-title">قضية جنائية حلها</div> --}}
    {{--                                        </div> --}}
    {{--                                    </div> --}}
    {{--                                </div> --}}

    {{--                                <!-- Column --> --}}
    {{--                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12"> --}}
    {{--                                    <div class="inner wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1500ms"> --}}
    {{--                                        <div class="content"> --}}
    {{--                                            <div class="icon flaticon-justice-scale"></div> --}}
    {{--                                            <div class="count-outer count-box"> --}}
    {{--                                                <span class="count-text" data-speed="3000" data-stop="6598">0</span>+ --}}
    {{--                                            </div> --}}
    {{--                                            <div class="counter-title">مساحة تجارية</div> --}}
    {{--                                        </div> --}}
    {{--                                    </div> --}}
    {{--                                </div> --}}

    {{--                                <!-- Column --> --}}
    {{--                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12"> --}}
    {{--                                    <div class="inner wow fadeInLeft" data-wow-delay="600ms" data-wow-duration="1500ms"> --}}
    {{--                                        <div class="content"> --}}
    {{--                                            <div class="icon flaticon-swear"></div> --}}
    {{--                                            <div class="count-outer count-box"> --}}
    {{--                                                <span class="count-text" data-speed="3000" data-stop="5646">0</span>+ --}}
    {{--                                            </div> --}}
    {{--                                            <div class="counter-title">المحامون العاملون</div> --}}
    {{--                                        </div> --}}
    {{--                                    </div> --}}
    {{--                                </div> --}}

    {{--                                <!-- Column --> --}}
    {{--                                <div class="column counter-column col-lg-6 col-md-6 col-sm-12"> --}}
    {{--                                    <div class="inner wow fadeInLeft" data-wow-delay="600ms" data-wow-duration="1500ms"> --}}
    {{--                                        <div class="content"> --}}
    {{--                                            <div class="icon flaticon-laurel-wreath"></div> --}}
    {{--                                            <div class="count-outer count-box"> --}}
    {{--                                                <span class="count-text" data-speed="3000" data-stop="1111">0</span>+ --}}
    {{--                                            </div> --}}
    {{--                                            <div class="counter-title">شركة مواقع عالمية</div> --}}
    {{--                                        </div> --}}
    {{--                                    </div> --}}
    {{--                                </div> --}}

    {{--                            </div> --}}

    {{--                        </div> --}}

    {{--                    </div> --}}
    {{--                </div> --}}

    {{--            </div> --}}

    {{--        </div> --}}
    {{--    </section> --}}

    <!-- Clients Section Two -->
    <section class="clients-section">
        <div class="outer-container">

            <div class="carousel-outer">
                <!--Sponsors Slider-->
                <ul class="sponsors-carousel owl-carousel owl-theme">

                    @foreach ($sponsors as $sponsor)
                        <li>
                            <div class="image-box">
                                <a target="_blank" href="{{ $sponsor->link }}">
                                    <img src="{{ asset('uploads/' . $sponsor->image) }}" alt="{{ $sponsor->title }}">
                                </a>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>

        </div>
    </section>
    <!-- End Clients Section Two -->


    <!-- Team Section -->
    <section class="team-section">
        <div class="auto-container">
            <!-- Sec Title -->
            <div class="sec-title centered">
                <div class="title">فريق العمل</div>
                <h2> المستشارين المنضمين حديثا </h2>
            </div>
            <div class="team-carousel owl-carousel owl-theme">
                @foreach ($Lawyers as $Lawyer)
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image">
                                <a href="{{ route('site.lawyer.show', $Lawyer->id) }}"><img src="{{ $Lawyer->photo }}"
                                        alt="" /></a>
                                <div class="color-layer"></div>
                            </div>
                            <div class="overlay-content">
                                <div class="designation">محامي أعمال</div>
                                <h5><a href="{{ route('site.lawyer.show', $Lawyer->id) }}">{{ $Lawyer->name }}</a></h5>
                                <div class="share-box">
                                    <div class="box-inner">
                                        <div class="share flaticon-plus"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Team Section -->

    {{--    @foreach ($posts as $post) --}}

    {{--        <div class="news-block col-lg-4 col-md-6 col-sm-12"> --}}
    {{--            <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms"> --}}
    {{--                <div class="image"> --}}
    {{--                    <a href="/post/{{ $post->slug }}"><img src="{{asset('uploads/'.$post->image)}}" alt="" /></a> --}}
    {{--                    <div class="post-date"> {{GetArabicDate($post->created_at)}} </div> --}}
    {{--                </div> --}}
    {{--                <div class="lower-content"> --}}
    {{--                    <div class="upper-box"> --}}
    {{--                        <div class="box-inner"> --}}
    {{--                            <div class="author-image"> --}}
    {{--                                <img src=" {{asset('uploads/lawyers/October2021/person.png')}}" alt="{{ $post->title }}" /> --}}
    {{--                            </div> --}}
    {{--                            <div class="author-name"> {{ $post->author }} </div> --}}
    {{--                            <ul class="post-meta"> --}}

    {{--                                <li><span class="icon flaticon-eye"></span> {{ $post->no_of_views }} مشاهدة</li> --}}
    {{--                            </ul> --}}
    {{--                        </div> --}}
    {{--                    </div> --}}
    {{--                    <h4><a href="/post/{{ $post->slug }}"> {{ $post->title }} </a></h4> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--        @endforeach --}}


    <!-- End News Section -->


    @if ($all_courses->count() > 0)
        <!-- Team Section -->
        <section class="team-section">
            <div class="auto-container">
                <!-- Sec Title -->
                <div class="sec-title centered">
                    <div class="title"> نافذة التدريب</div>
                    <h2> دورات المكتب </h2>
                </div>
                <div class="team-carousel owl-carousel owl-theme">
                    @foreach ($all_courses as $course)
                        <div class="team-block">
                            <div class="inner-box">
                                <div class="image">
                                    <a href="{{ route('site.training.view.course', $course->id) }}"><img
                                            src="{{ asset('uploads/' . $course->image) }} " alt="{{ $course->title }}" />
                                        {{ $course->title }}
                                    </a>
                                    <div class="color-layer">

                                    </div>
                                </div>
                                <div class="overlay-content">
                                    <div class="designation">
                                        <span class="flaticon-map"></span> {{ $course->location }}
                                    </div>
                                    <h5>
                                        <a
                                            href="{{ route('site.training.view.course', $course->id) }}">{{ $course->title }}</a>
                                    </h5>
                                    <div style="width: 75px;" class="share-box">
                                        <div class="box-inner">
                                            <!--<div class="share flaticon-plus"></div>-->
                                            <div style="width: 75px;" class="share"> {{ $course->price }} ر.س</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- End Team Section -->
    @endif



    <!-- CTA Section Four -->
    <section class="cta-section-four">
        <div class="auto-container">
            <div class="inner-container">
                <div class="pattern-layer-one" style="background-image:url(site/images/icons/cta-pattern-1.png)"></div>
                <div class="pattern-layer-two" style="background-image:url(site/images/icons/cta-pattern-2.png)"></div>
                <div class="row clearfix">
                    <!-- Title Column -->
                    <div class="title-column col-lg-9 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="icon flaticon-auction-2"></div>
                            <h3>تحدث مع خبرائنا اليوم</h3>
                            <div class="text">تتمتع شركة يمتاز للمحاماة والمحاماة بعمق المواهب القانونية التي تحتاجها
                                للفوز بقضيتك.
                            </div>
                        </div>
                    </div>
                    <!-- Button Column -->
                    <div class="button-column col-lg-3 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <a href="{{ env('REACT_WEB_LINK') . '/contact-us' }}" class="theme-btn btn-style-three"><span
                                    class="txt">تواصل معانا</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End CTA Section Four -->
@endsection
