<style>
	.designation{
		text-align: justify
	}
</style>
@extends('site.layouts.main')
@section('title',$service->title)
@section('content')
        <!-- Page Title -->
        <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
            <div class="auto-container">
                <div class="side-icon">
                    <img src="{{asset('images/logo.png')}}" alt="" />
                </div>
                <h2>{{$service->title}}</h2>
                @include('site.website_main_banner')
                @if(Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                <a href="/signin">
                    <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

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
					<div class="image-column col-lg-4 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="image">
								<img src="{{($service->image == "person.png") ? asset('uploads/person.png') : $service->image}}" alt="{{ $service->title }}" />
							</div>
						</div>
					</div>
					<!-- Content Column -->
					<div class="content-column col-lg-8 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="title"> </div>
                            <div class="name_lawyer">
                                <h2>{{ $service->title }}</h2>
							</div>

							<div class="designation">
                                {{ $service->intro }}
							</div>

							<div class="designation">
                                {!! $service->details !!}
							</div>

							@if(auth()->guard('client')->check())
							    <div class="designation">
							        <a href="{{route('site.client.service-request.create')}}" class="theme-btn btn-style-three">
							            <span style="color: #fff;" class="txt"> طلب الخدمة </span>
						            </a>
						        </div>
					        @else
					            <div class="designation">
							        <a href="{{route('site.client.service-request.create-visitor-service',$service->id)}}" class="theme-btn btn-style-three">
							            <span style="color: #fff;" class="txt"> طلب الخدمة </span>
						            </a>
						        </div>
							@endif

						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
@endsection
