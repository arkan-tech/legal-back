@extends('site.layouts.main')
@section('title','من نحن')
@section('content')
    <!-- Page Title -->
    <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
        <div class="auto-container">
            <div class="side-icon">
                <img src="{{asset('site/images/logo.png')}}" alt=""/>
            </div>
            <h2>من نحن</h2>
            <ul class="page-breadcrumb">
                <li><a href="/">الرئيسية</a></li>
                <li>من نحن</li>
            </ul>

            @include('site.website_main_banner')

            @if(Session::get('loggedInUserID') != '')
                @if(GetName('lawyers', 'office_request', 'id', Session::get('loggedInUserID')) == 1)
                    @if(GetName('lawyers', 'office_request_status', 'id', Session::get('loggedInUserID')) == 1)
                        @php
                            $lawyerEmail = GetName('lawyers', 'Email', 'id', Session::get('loggedInUserID'));
                            $lawyerPassword = GetName('lawyers', 'Password', 'id', Session::get('loggedInUserID'));
                            $lawyerPaidStatus = GetName('lawyers', 'paid_status', 'id', Session::get('loggedInUserID'));
                        @endphp
                        @if($lawyerPaidStatus == 1)
                            <a target="_blank"
                               href="https://lawyer.ymtaz.sa/dashboard?email={{ $lawyerEmail }}&password={{ $lawyerPassword }}">
                                <div class="side-tag">
                                    المكتب الإلكترونى
                                </div>
                            </a>
                        @else
                            <a href="/show-payment-rules">
                                <div class="side-tag">
                                    قم باتمام الدفع
                                </div>
                            </a>
                        @endif
                    @else
                        <div class="side-tag">
                            جارى مراجعة طلب الانضمام الخاص بكم
                        </div>
                    @endif
                @else
                    <a data-id="{{ Session::get('loggedInUserID') }}" class="apply-office_" href="#">
                        <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                    </a>
                @endif
            @endif


            @if(Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                <a href="/signin">
                    <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                </a>
            @endif
        </div>
    </section>
    <!-- End Page Title -->


    <!-- About Section -->
    <section class="about-section">
        <div class="auto-container">
            <div class="clearfix row">

                <!-- Image Column -->
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <!-- <div class="inner-column">
						<div class="pattern-layer" style="background-image:url(site/images/background/pattern-2.png)"></div>
						<div class="image wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
							<img src="<?= Storage::url('app/public/' . $About->Image);?>" alt="" />
						</div>
					</div> -->

                    <div class="inner-column">
                        <div class="pattern-layer"
                             style="background-image:url('{{asset('site/images/background/pattern-2.png')}}')"></div>
                        <div class="image wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <img src="{{asset('uploads/'.$About->Image)}}" alt=""/>
                        </div>
                        <div class="image-two wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <img src="{{asset('uploads/'.$About->second_image)}}" alt=""/>
                        </div>
                    </div>
                </div>

                <!-- Content Column -->
                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <div class="title">{{$About->Title}}</div>
                        </div>
                        <div class="text">
                            <?=$About->details;?>
                        </div>

                    </div>
                </div>


            </div>
            <div class="law-image">
                <img src="{{asset('site/images/law.png')}}" alt=""/>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <!-- Fluid Section One / Style Two -->
    <section class="fluid-section-one style-two">
        <div class="clearfix outer-container">
            <div class="pattern-layer" style="background-image:url('{{asset('site/images/background/pattern-9.png')}}')"></div>
            <!-- Content Column -->
            <div class="clearfix content-column">
                <div class="inner-column">
                    <div class="icon"><img src="{{asset('site/images/logo.png')}}" alt=""/></div>
                    <div class="title">24+ سنوات من الخبرة</div>
                    <h2>بحاجة إلى مشورة <br> من محامي خبير </h2>
                    <a class="phone" href="tel:+966534337090">0534337090</a>
                    <a href="#" class="theme-btn btn-style-one"><span class="txt">طلب استشارة</span></a>
                </div>
            </div>

            <!-- Skill Column -->
            <div class="clearfix skill-column">
                <div class="inner-column">
                    <!-- Sec Title -->
                    <div class="sec-title style-two">
                        <div class="title">تقديم نطاق واسع
                        </div>
                        <h2>من الخدمات القانونية والمهنية برؤية ومنهجية
                        </h2>
                    </div>

                    <div class="row">
                        <div class="content-column">
                            <div class="inner-column-mission">
                                <div class="blocks-outer">

                                    <!-- Feature Block Two -->
                                    <div class="feature-block-two">
                                        <div class="inner-box">
                                            <div class="icon-box">
                                                <span class="number">01</span>
                                                <span class="icon flaticon-strategy"></span>
                                            </div>
                                            <h4>{{$Mission->Title}}</h4>
                                            <div class="featured-text">{!! $Mission->details !!}</div>
                                        </div>
                                    </div>

                                    <!-- Feature Block Two -->
                                    <div class="feature-block-two">
                                        <div class="inner-box">
                                            <div class="icon-box">
                                                <span class="number">02</span>
                                                <span class="icon flaticon-handshake"></span>
                                            </div>
                                            <h4>{{$Vision->Title}}</h4>
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
    </section>
    <!-- End Fluid Section One -->




    <!-- Faq Section -->
    <section class="faq-section">
        <div class="auto-container">
            <div class="clearfix row">

                <!-- Client Column -->
                <div class="client-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <div class="title">مميزاتنا
                            </div>

                        </div>
                        <div class="blocks-outer">

                            @foreach($Advantages as $Advantage)
                                <!-- Client Block -->
                                <div class="client-block">
                                    <div class="inner-box">
                                        <div class="icon flaticon-medal"></div>
                                        <div class="text">{{$Advantage->Title}}</div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <!-- Faq Column -->
                <div class="faq-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <div class="title">الاسئله الشائعة</div>
                        </div>

                        <!--Accordian Box-->
                        <ul class="accordion-box">


                            @foreach($Faq as $SFaq)
                                <!--Block-->
                                <li class="block accordion">
                                    <div class="acc-btn @if ($loop->first)active @endif">
                                        <div class="icon-outer"><span class="icon icon-plus fa fa-plus"></span>
                                            <span class="icon icon-minus fa fa-minus"></span></div>
                                        {{ $SFaq->Title }}
                                    </div>
                                    <div class="acc-content @if ($loop->first)current @endif">
                                        <div class="content">
                                            <div class="text">
                                                <p>
                                                    {{ $SFaq->details }}

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach


                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Faq Section -->


    <section class="cta-section-four">
        <div class="auto-container">
            <div class="inner-container">
                <div class="pattern-layer-one" style="background-image:url('{{asset('site/images/icons/cta-pattern-1.png')}}')"></div>
                <div class="pattern-layer-two" style="background-image:url('{{asset('site/images/icons/cta-pattern-2.png')}}')"></div>
                <div class="clearfix row">
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
                            <a href="/contact" class="theme-btn btn-style-three"><span
                                    class="txt">تواصل معانا</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End CTA Section Four -->
@endsection
