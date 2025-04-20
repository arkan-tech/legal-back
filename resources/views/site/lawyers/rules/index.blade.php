<style>
	.designation{
		text-align: justify
	}
</style>
@extends('site.layouts.main')

@section('content')
        <!-- Page Title -->
        <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
            <div class="auto-container">
                <div class="side-icon">
                    <img src="{{asset('site/images/logo.png')}}" alt="" />
                </div>
                <h2>{{$rules->Title}}</h2>
				<ul class="page-breadcrumb">
                    <li><a href="/">الرئيسية</a></li>
                    <li>{{$rules->Title}}</li>
                </ul>
                <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>
            </div>
        </section>
        <!-- End Page Title -->
	<!-- Team Detail Section -->
    <section class="team-detail-section">
		<div class="auto-container">
			<div class="upper-box">
				<div class="row clearfix">

					<div class="content-column col-lg-12 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="title"> </div>
                            <div class="name_lawyer">
                                <h2>{{ $rules->Title }}</h2>
							</div>
							<div class="designation">
								{!! $rules->details !!}
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
	</section>



@endsection
