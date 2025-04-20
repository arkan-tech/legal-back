@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 20% ;margin-bottom: 20%">
                <h1> المدونة</h1>
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
    <!---end header-->
@endsection

@section('electronic_office_content')

    <!--about--->
    <section>

        <div class="auto-container mt-5">
            <div class="row clearfix">
                <!-- Sidebar Side -->
                <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar sticky-top">
                        <!-- Categories Widget -->
                        <div class="sidebar-widget categories-widget">
                            <div class="widget-content">
                                <!-- Sidebar Title -->
                                <div class="sidebar-title">
                                    <h3>اقسام المكتبة </h3>
                                </div>
                                <ul class="nav nav-tabs blog-cat" role="tablist">
                                        <li>
                                            <a data-toggle="tab" href="#tabs-1" class="active"
                                               role="tab">سيسيبسيبسيب<span>345345345345</span></a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tabs-1" class="active"
                                               role="tab">سيسيبسيبسيب<span>345345345345</span></a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tabs-1" class="active"
                                               role="tab">سيسيبسيبسيب<span>345345345345</span></a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tabs-1" class="active"
                                               role="tab">سيسيبسيبسيب<span>345345345345</span></a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tabs-1" class="active"
                                               role="tab">سيسيبسيبسيب<span>345345345345</span></a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tabs-1" class="active"
                                               role="tab">سيسيبسيبسيب<span>345345345345</span></a>
                                        </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
                <!-- Content Side -->
                <div class="content-side col-lg-8 col-md-12 col-sm-12">
                    <div class="tab-content">
                            <div class="tab-pane active " id="tabs-1" role="tabpanel">
                                <div class="our-shops">
                                    <!--Shop Single-->
                                    <div class="shop-section">
                                        <!--Sort By-->
                                        <div class="items-sorting">
                                            <div class="row clearfix">
                                                <div class="results-column col-md-12">
                                                    <h6 class="text-center">ييشسبشسيب</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="our-shops">
                                            <div class="row clearfix">

                                                    <div
                                                        class="single-product-item col-lg-4 col-md-6 col-sm-12 text-center">
                                                        <div class="img-holder">
                                                            <img width="270" height="300"
                                                                 src="#"
                                                                 class="" alt="">
                                                        </div>
                                                        <div class="title-holder text-center">
                                                            <div class="static-content">
                                                                <h3 class="title text-center">
                                                                    <a href="#">سيبلسبلسيبل</a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <!-- Post Share Options -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--end about-->

@endsection
