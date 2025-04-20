<style>
	.designation{
		text-align: justify
	}
</style>
@extends('site.layouts.main')
@section('title',$post->title)
@section('content')
        <!-- Page Title -->
        <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
            <div class="auto-container">
                <div class="side-icon">
                    <img src="{{asset('images/logo.png')}}" alt="" />
                </div>
                <h2>{{$post->title}}</h2>

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
								<img src=" {{$post->image}}" alt="{{ $post->title }}" />
							</div>
						</div>
					</div>
					<!-- Content Column -->
					<div class="content-column col-lg-8 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="title"> </div>
                            <div class="name_lawyer">
                                <h2>{{ $post->title }}</h2>
                                @if(Session::get('loggedInUserID') != '')
								<ul class="post-meta">
									<li>
										<a title="" href="{{ route('participate.course', ['id'=> $post->id]) }}" class="theme-btn btn-style-three">
										    <span class="txt">({{ $post->price.' ر.س' }})
										    اشترك بالدورة  </span>
									    </a>
									</li>
								</ul>
                                @endif
							</div>
							<p>
								<i class="fa fa-calendar"></i> {{GetArabicDate($post->course_date)}}
							</p>

							<p>
								<i class="fa fa-user"></i> المدرب:  {{ $post->coach }}
							</p>
                            <p>
                                <i class="flaticon-map"></i> {{ $post->location }}
                            </p>
							<div class="designation">
                                {!! $post->details !!}
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>

@endsection
