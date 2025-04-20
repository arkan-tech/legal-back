@extends('site.layouts.main')
@section('title','نافذة التدريب')
@section('content')
<style>
    .news-block .inner-box .lower-content .upper-box .box-inner {
        padding-right: 0px !important;
        padding-top: 20px;
        padding-left: 0;
    }
    .news-block .inner-box .lower-content .upper-box .box-inner .author-name{
        font-size: 18px;
    }
    .news-block .inner-box .lower-content h4{
        font-size: 25px
    }
</style>

        <!-- Page Title -->
        <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
            <div class="auto-container">
                <div class="side-icon">
                    <img src="{{asset('site/images/logo.png')}}" alt="" />
                </div>
                <h2> خدماتنا </h2>
                <ul class="page-breadcrumb">
                    <li><a href="/">الرئيسية</a></li>
                    <li> نافذة التدريب </li>
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
                    <div class="title"> نافذة التدريب </div>
                    <h2> دورات المكتب </h2>
                </div>
                <div class="row clearfix">


                @foreach($all_courses as $course)

				<!-- News Block -->
				<div class="news-block col-lg-4 col-md-6 col-sm-12">
					<div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
						<div class="image">
                            <a href="{{route('site.training.view.course', $course->id) }}">
                                <img src="{{$course->image}}" alt="" />
                            </a>
							<div class="post-date"> {{GetArabicDate($course->course_date) }} </div>
						</div>
						<div style="padding-top: 0px; padding-bottom: 0px" class="lower-content">
                            <h4 class="text-center">
                                <a href="{{route('site.training.view.course', $course->id) }}">
                                    {{ $course->title }} </a>
                            </h4>
                            <!-- Upper Box -->
							<div class="upper-box">
								<div class="box-inner row">
									<!-- <div class="author-image">
										<img src="<?= Storage::url('person.png') ;?>" alt="{{ $course->title }}" />
									</div> -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="author-name">
                                            <i class="fa fa-user"></i>
                                            {{ $course->coach }}
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div style="padding-left: 20px" class="author-name text-left">
                                            <i class="fa fa-map-marker"></i>
                                            {{ $course->location }}
                                        </div>
                                    </div>

								</div>
							</div>

						</div>
					</div>
				</div>
			@endforeach


                </div>
            </div>
        </section>

@endsection
