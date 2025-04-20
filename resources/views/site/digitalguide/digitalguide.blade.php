@extends('site.layouts.main')
@section('title','الدليل الرقمي')
@section('content')
    <!-- Page Title -->
    <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
        <div class="auto-container">
            <div class="side-icon">
                <img src="{{asset('site/images/logo.png')}}" alt=""/>
            </div>
            <h2>الدليل الرقمي</h2>
            <ul class="page-breadcrumb">
                <li><a href="/">الرئيسية</a></li>
                <li>الدليل الرقمي</li>
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
                <div class="title">الدليل الرقمي</div>
                <h2>خارطة المهن في المنصة</h2>
            </div>
            <div class="row clearfix">
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">
                    <div class="styled-form register-form">
                        <form action="{{route('site.lawyer.search')}}" method="get">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <span class="adon-icon"><span class="fa fa-user"></span></span>
                                        <select id="section" class="select2" name="section">
                                            <option value="">المهنة</option>
                                            {{GetSelectItem('digital_guide_sections','title','')}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <span class="adon-icon"><span class="fa fa-globe"></span></span>
                                        <select class="form-control select2" id="country" name="country">
                                            <option value="">الدولة</option>
                                            {{GetSelectItem('countries','name','')}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <span class="adon-icon"><span class="fa fa-map-marker"></span></span>
                                        <select class="select2" id="city" name="city">
                                            <option value="">المدينة</option>
                                            {{GetSelectItem('cities','title','')}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <button style="padding: 0px 50px; height: 50px" type="submit"
                                            class="theme-btn btn-style-three">
                                        <span class="txt"> بحـــث </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row clearfix">


                @foreach($DigitalGuideCategories as $DigitalGuideCategory)
                    <div class="price-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box"
                             style="background-image:url('{{asset('site/images/background/pattern-7.png')}}')">
                            <div class="color-one-layer"></div>
                            <div class="color-two-layer"></div>
                            <div class="icon flaticon-civil-right"></div>
                            <div class="side-icon flaticon-civil-right"></div>
                            <div class="price"><span>
                                    {{$DigitalGuideCategory->title}}</span>
                                {{GetSectionCount($DigitalGuideCategory->id)}}
                            </div>
                            <a href="{{route('site.digital.guide.categories', $DigitalGuideCategory->id)}}"
                               class="theme-btn btn-style-four"><span class="txt">عرض </span></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
