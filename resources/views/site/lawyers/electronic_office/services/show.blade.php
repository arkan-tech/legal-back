@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 20% ;margin-bottom: 20%">
                <h2> {{ $service->title }}</h2>
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
    <div class="sec-title text-center mt-5 mb-5">
        <h3 style="color: #dd9b25 ; font-weight: bold;"> خدماتنا </h3>
        <h2 style="color: #dd9b25 ; font-weight: bold;"> الخدمات اللى يقدمها المكتب </h2>
    </div>
    <div class="auto-container row ">
        <!-- Team Detail Section -->
        <section class="team-detail-section">
            <div class="auto-container">
                <div class="upper-box">
                    <div class="row clearfix">
                        <!-- Image Column -->
                        <div class="image-column col-lg-4 col-md-12 col-sm-12">
                            <div class="inner-column">
                                <div class="image">
                                    <img src="{{$service->image}}"/>
                                </div>
                            </div>
                        </div>
                        <!-- Content Column -->
                        <div class="content-column col-lg-8 col-md-12 col-sm-12">
                            <div class="inner-column">
                                <div class="title"></div>
                                <div class="name_lawyer">
                                    <h2>{{ $service->title }}</h2>
                                </div>

                                <div class="designation">
                                    {!! $service->description !!}
                                </div>
                                <div class="designation">
                                    <div style="height: 110px;overflow: hidden; color: #dd9b25" class="text"> السعر
                                        : {{$service->price .' '.' ر.س'}}  </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!--end about-->

@endsection
