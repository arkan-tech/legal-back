@extends('site.layouts.main')
@section('title','هيئة المستشارين')
@section('content')
        <!-- Page Title -->
        <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
            <div class="auto-container">
                <div class="side-icon">
                    <img src="{{asset('site/images/logo.png')}}" alt="" />
                </div>
                <h2>هيئة المستشارين</h2>
                <ul class="page-breadcrumb">
                    <li><a href="/">الرئيسية</a></li>
                    <li>هيئة المستشارين</li>
                </ul>
                @include('site.website_main_banner')

                @if(Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                <a href="/signin">
                    <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                </a>
				@endif
            </div>
        </section>
        <!-- End Page Title -->

        <section class="pricing-section digital_guide">
            <div class="auto-container">
                <!-- Sec Title -->
                <div class="sec-title centered">
                    <div class="title">هيئة المستشارين</div>
                </div>
                <div class="row clearfix">

                @foreach($DigitalGuideCategories as $DigitalGuideCategory)
                    <div class="price-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box" style="background-image:url('{{asset('site/images/background/pattern-7.png')}}')">
                            <div class="color-one-layer"></div>
                            <div class="color-two-layer"></div>
                            <div class="icon flaticon-civil-right"></div>
                            <div class="side-icon flaticon-civil-right"></div>
                            <div class="price">
                                <span>{{$DigitalGuideCategory->title}}</span>
                                <span style="font-size: 30px">{{getAdvisorCatLawyersCount($DigitalGuideCategory->id)}}</span>
                            </div>
                            <a href="{{route('site.training.cat.category',$DigitalGuideCategory->id)}}" class="theme-btn btn-style-four"><span class="txt">عرض </span></a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </section>
@endsection
