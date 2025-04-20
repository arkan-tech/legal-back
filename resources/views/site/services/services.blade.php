@extends('site.layouts.main')
@section('title','خدماتنا')
@section('content')

        <!-- Page Title -->
        <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
            <div class="auto-container">
                <div class="side-icon">
                    <img src="{{asset('site/images/logo.png')}}" alt="" />
                </div>
                <h2> خدماتنا </h2>
                <ul class="page-breadcrumb">
                    <li><a href="/">الرئيسية</a></li>
                    <li> خدماتنا </li>
                </ul>
                @include('site.website_main_banner')
            </div>
        </section>
        <!-- End Page Title -->

        <section class="pricing-section digital_guide">
            <div class="auto-container">
                <!-- Sec Title -->
                <div class="sec-title centered">
                    <div class="title"> خدماتنا </div>
                    <h2> الخدمات اللى تقدمها شركة يمتاز للمحاماة و الإستشارات القانونية </h2>
                </div>
                <div class="row clearfix">
                @foreach($services as $service)
                    <!-- Service Block -->
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="service-block">
                            <div class="inner-box">
                                <div class="image">

                                    <a href="{{route('site.services.show' ,$service->id)}}">
                                        <img src="{{$service->image}}" alt="{{ $service->title }}" /></a>
                                </div>
                                <div class="lower-content">
                                    <a href="{{route('site.services.show' ,$service->id)}}" class="arrow flaticon-next-2"></a>
                                    <h4><a href="{{route('site.services.show' ,$service->id)}}"> {{ $service->title }} </a></h4>
                                    <div style="height: 110px;overflow: hidden;" class="text"> {{ $service->intro }} </div>
                                    <div class="side-icon flaticon-auction"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


                </div>
            </div>
        </section>

@endsection
