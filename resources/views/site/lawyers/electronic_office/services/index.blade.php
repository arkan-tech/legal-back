@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue',['id'=>$id])
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 20% ;margin-bottom: 20%">
                <h2> الخدمات</h2>
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
        @foreach($services as $service)
            <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                <div class="service-block">
                    <div class="inner-box">
                        <div class="image">
                            <a href="{{route('site.lawyer.electronic-office.servicesShow',['id'=>$service->id,'electronic_id_code'=>$id])}}">
                                <img style="" src="{{$service->image}}"
                                     alt="{{$service->title}}"/></a>
                        </div>
                        <div class="lower-content text-center">
                            <a href="{{route('site.lawyer.electronic-office.servicesShow',['id'=>$service->id,'electronic_id_code'=>$id])}}"
                               class="arrow flaticon-next-2"></a>
                            <h4><a href="{{route('site.lawyer.electronic-office.servicesShow',['id'=>$service->id,'electronic_id_code'=>$id])}}" style="color: #dd9b25"> {{$service->title}} </a></h4>
                            <div style="height: 110px;overflow: hidden; color: #dd9b25" class="text"> السعر
                                : {{$service->price .' '.' ر.س'}}  </div>
                            <div class="side-icon flaticon-auction"></div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!--end about-->

@endsection
