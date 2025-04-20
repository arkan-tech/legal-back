{{--    <div class="preloader"></div> --}}

<!-- Main Header -->
<header class="main-header">
    <!--Header-Upper-->
    <div class="header-upper">
        <div class="outer-container">
            <div class="clearfix">
                <div class="pull-left logo-box">
                    <div class="logo">
                        <a href="/"><img src="{{ asset('site/images/logo.png') }}" alt=""
                                title="" /></a>
                    </div>
                </div>
                <div class="pull-left upper-right clearfix">
                    <!-- Info Box -->
                    <div style="width: 20%" class="upper-column info-box">
                        <div class="icon-box"><span class="flaticon-email-5"></span></div>
                        <ul>
                            <li>
                                <a href="mailto:{{ setting('site.email') }}">
                                    {{ setting('site.email') }}
                                </a>
                            </li>
                            <li><strong>تواصل معانا عبر</strong></li>
                        </ul>
                    </div>

                    <!-- Info Box -->
                    <div style="width: 20%" class="upper-column info-box">
                        <div class="icon-box"><span class="flaticon-location"></span></div>
                        <ul>
                            <li>{{ setting('site.address') }}</li>
                            <li><strong>العنوان</strong></li>
                        </ul>
                    </div>

                    <!-- Info Box -->
                    <div style="width: 30%" class="upper-column info-box">
                        <div class="icon-box"><span class="flaticon-alarm-clock"></span></div>
                        <ul>
                            <li>{{ setting('site.working.hours') }}</li>
                            <li><strong>ساعات العمل</strong></li>
                        </ul>
                    </div>

                    <!-- Info Box -->
                    <div class="upper-column info-box">
                        <div class="icon-box"><span class="flaticon-telephone-1"></span></div>
                        <ul>
                            <li>اطلب المساعدة</li>
                            <li>
                                <strong>
                                    {{ setting('site.phone2') }}
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Nav Btn -->
            <div class="nav-btn navSidebar-button"><span class="icon flaticon-menu"></span></div>
        </div>
    </div>
    <!--End Header Upper-->

    <!--Header Lower-->
    <div class="header-lower">
        <div class="auto-container">
            <div class="nav-outer clearfix">
                <!-- Mobile Navigation Toggler -->
                <div class="mobile-nav-toggler"><span class="icon flaticon-menu-2"></span></div>
                <!-- Main Menu -->
                <nav class="main-menu show navbar-expand-md">
                    <div class="navbar-header">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                        <ul class="navigation clearfix">
                            <li class="current"><a href="/">الرئيسية</a></li>
                            <li><a href="{{ route('site.about') }}">من نحن</a></li>
                            <li><a href="{{ route('site.services') }}"> خدماتنا </a></li>
                            <li><a href="{{ route('site.training') }}"> نافذة التدريب </a></li>
                            <li><a href="{{ route('site.advisory') }}">هيئة المستشارين</a></li>
                            <li><a href="{{ route('site.digital.guide') }}">الدليل الرقمي</a></li>
                            <li><a href="{{ route('site.video.index') }}">القناة الثقافية</a></li>
                            <li><a href="{{ route('site.library.index') }}">المكتبة</a></li>
                            <li class="dropdown">
                                <a href="#">
                                    <span class="txt"> الدليل العدلى </span>
                                </a>
                                <ul class="dropdown-menu" style="">
                                    {{--                                    @foreach (\App\Models\JusticeGuideCategory\JusticeGuideCategory::where('parent_id', 0)->get() as $category) --}}
                                    {{--                                        <li> --}}
                                    {{--                                            <a class="dropdown-item" --}}
                                    {{--                                               href="{{route('site.justice.guide.cat.index',$category->id)}}"> --}}
                                    {{--                                                {{ $category->name }} --}}
                                    {{--                                            </a> --}}
                                    {{--                                        </li> --}}
                                    {{--                                    @endforeach --}}
                                </ul>

                            </li>

                            <li><a href="{{ env('REACT_WEB_LINK') . '/contact-us' }}">اتصل بنا</a></li>
                            @if (auth()->guard('lawyer')->check())
                                <li class="dropdown">
                                    <a href="#">
                                        <span class="txt"> <i class="fa fa-user"></i> مرحبا,
                                            {{ auth()->guard('lawyer')->user()->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu" style="">
                                        @if (auth()->guard('lawyer')->user()->accepted == 2)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('site.lawyer.profile.show') }}">
                                                    الملف
                                                    الشخصي </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ route('site.lawyer.administrative-office.index') }}">
                                                    المكتب الاداري </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('site.lawyer.electronic-office.index') }}">
                                                    المكتب الالكتروني </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('site.lawyer.logout') }}"> تسجيل
                                                الخروج </a>
                                        </li>
                                    </ul>
                                </li>
                                {{--                                <li> --}}
                                {{--                                    <a href="{{route('site.lawyer.received.email')}}"> --}}
                                {{--                                                <span class="lawyer-messages-count"> --}}
                                {{--                                                </span> --}}
                                {{--                                        <i class="fa fa-envelope"></i> الرسائل الواردة --}}
                                {{--                                    </a> --}}
                                {{--                                </li> --}}
                            @elseif(auth()->guard('client')->check())
                                <li class="dropdown">
                                    <a href="#"><span class="txt">

                                            <i class="fa fa-user"></i> مرحبا,
                                            {{ auth()->guard('client')->user()->myname }}
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu" style="">
                                        @if (auth()->guard('client')->user()->accepted == 2)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('site.client.profile.index') }}">
                                                    الملف الشخصى </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('site.client.logout') }}"> تسجيل
                                                الخروج </a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="{{ env('REACT_WEB_LINK') . '/auth/signin' }}"><span class="txt"> تسجيل
                                            الدخول </span></a>
                                    {{--                                    <ul class="dropdown-menu" style=""> --}}
                                    {{--                                        <li> --}}
                                    {{--                                            <a class="dropdown-item" href="{{route('site.lawyer.show.login.form')}}"> --}}
                                    {{--                                                مقدم خدمة </a> --}}
                                    {{--                                        </li> --}}

                                    {{--                                        <li> --}}
                                    {{--                                            <a class="dropdown-item" href="{{route('site.client.show.login.form')}}"> --}}
                                    {{--                                                عميل </a> --}}
                                    {{--                                        </li> --}}

                                    {{--                                    </ul> --}}
                                </li>
                            @endif

                        </ul>
                    </div>
                </nav>
                <!-- Main Menu End-->

                <!-- Options Box -->
            </div>
        </div>
    </div>
    <!-- End Header Lower -->

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn"><span class="icon flaticon-multiply"></span></div>

        <nav class="menu-box">
            <div class="nav-logo">
                <a href="/">
                    <img src="{{ asset('site/images/logo.png') }}" alt="" title="" />
                </a>
            </div>
            <div class="menu-outer">
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            </div>
        </nav>
        <!-- Options Box -->
        <div class="options-box clearfix">
            <!-- Search Box -->
            <div class="search-box-outer">
                <div class="search-box-btn"><span class="fa fa-search"></span></div>
            </div>

            <div class="social-box">
                <!-- Social Box -->
                <ul class="social-icons">
                    <li>
                        <a href=""><span class="fa fa-google-plus"></span></a>
                    </li>
                    <li>
                        <a href=""><span class="fa fa-twitter"></span></a>
                    </li>
                    <li>
                        <a href=""><span class="fa fa-youtube"></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Mobile Menu -->
</header>
<!-- End Main Header -->
<!-- Sidebar Cart Item -->
<div class="xs-sidebar-group info-group">
    <div class="xs-overlay xs-bg-black"></div>
    <div class="xs-sidebar-widget">
        <div class="sidebar-widget-container">
            <div class="widget-heading">
                <a href="#" class="close-side-widget">
                    X
                </a>
            </div>
            <div class="sidebar-textwidget">
                <!-- Sidebar Info Content -->
                <div class="sidebar-info-contents">
                    <div class="content-inner">
                        <div class="logo">
                            <a href="/"><img src="{{ asset('site/images/logo.png') }}" alt="" /></a>
                        </div>
                        <div class="content-box">
                            <h2>من نحن</h2>
                            <p class="text"></p>

                            @if (Session::get('loggedInUserID') != '')
                                <a class="theme-btn btn-style-two" href="/logout"><span class="txt"> تسجيل
                                        الخروج </span></a>
                            @elseif(Session::get('loggedInClientID') != '')
                                <a class="theme-btn btn-style-two" href="/client-logout"><span class="txt">
                                        تسجيل الخروج </span></a>
                            @endif

                        </div>
                        <div class="contact-info">
                            <h2>معلومات التواصل</h2>
                            <ul class="list-style-two">
                                <li>
                                    <span class="icon fa fa-location-arrow"></span>
                                </li>
                                <li>
                                    <span class="icon fa fa-phone"></span>

                                </li>
                                <li>
                                    <span class="icon fa fa-envelope"></span>

                                </li>
                                <li>
                                    <span class="icon fa fa-clock-o"></span>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END sidebar widget item -->
