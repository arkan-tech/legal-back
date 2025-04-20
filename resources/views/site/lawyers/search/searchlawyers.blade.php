@extends('site.layouts.main')
@section('title','نتيجةالبحث')
@section('content')



        <!-- Page Title -->
        <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
            <div class="auto-container">
                <div class="side-icon">
                    <img src="{{asset('site/images/logo.png')}}" alt="" />
                </div>
                <h2></h2>
                <ul class="page-breadcrumb">
                    <li><a href="/">الرئيسية</a></li>
                    <li><a href="{{route('site.digital.guide')}}">الدليل الرقمي</a></li>
                    <li>نتيجة البحث</li>
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




		<!-- Team Section Two -->
        <section class="team-section">
            <div class="auto-container">
                <!-- Sec Title -->
                <div class="sec-title centered">
                    <div class="title"> نتيجة البحث </div>
                </div>
                <div class="row clearfix">

            @if($Lawyers->isEmpty())
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 style="text-align: center; font-size: 25px; direction: rtl;">
                        لا يوجد نتائج بحث متوفره .
                    </h1>
                </div>
            @else
                @foreach($Lawyers as $Lawyer)
                <!-- Team Block Two -->
                <div class="team-block-two col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box">
                        <div class="image">
                            <a href="{{route('site.lawyer.show', $Lawyer->id)}}">
                                <img src="{{($Lawyer->photo == "person.png") ? asset('uploads/person.png') : asset($Lawyer->photo)}}" alt="" />
                            </a>
                            <div class="color-layer"></div>
                            <!-- Social Box -->
                            <ul class="social-box">
                            <li> {{$Lawyer->about}}</li>
                            </ul>
                        </div>
                        <div class="lower-content">
                            <h5><a href="{{route('site.lawyer.show', $Lawyer->id)}}">{{$Lawyer->name}}</a></h5>
                        </div>
                    </div>
                </div>

                @endforeach
            @endif

                </div>
            </div>
        </section>
        <!-- End Team Section Two -->


		<section class="cta-section-four">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="pattern-layer-one" style="background-image:url('{{asset('site/images/icons/cta-pattern-1.png')}}')"></div>
                    <div class="pattern-layer-two" style="background-image:url('{{asset('site/images/icons/cta-pattern-2.png')}}')"></div>
                    <div class="row clearfix">
                        <!-- Title Column -->
                        <div class="title-column col-lg-9 col-md-12 col-sm-12">
                            <div class="inner-column">
                                <div class="icon flaticon-auction-2"></div>
                                <h3>تحدث مع خبرائنا اليوم</h3>
                                <div class="text">تتمتع شركة يمتاز للمحاماة والمحاماة بعمق المواهب القانونية التي تحتاجها للفوز بقضيتك.</div>
                            </div>
                        </div>
                        <!-- Button Column -->
                        <div class="button-column col-lg-3 col-md-12 col-sm-12">
                            <div class="inner-column">
                                <a href="/contact" class="theme-btn btn-style-three"><span class="txt">تواصل معانا</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End CTA Section Four -->
	<!-- Main Footer -->

@endsection
