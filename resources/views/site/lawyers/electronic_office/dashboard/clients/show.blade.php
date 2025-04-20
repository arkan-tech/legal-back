@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 15% ;margin-bottom: 15%">
                <h1> لوحة تحكم </h1>
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

    <div class="row " style="max-width: 100%">

        <!--Login Form-->
        @include('site.lawyers.electronic_office.dashboard.layouts.side_menue')

        <div class="col-lg-9  mt-3 mb-3">


            <div class="card-header border-bottom">
                <h4 class="card-title text-center"> عرض معلومات العميل </h4>
            </div>


            <div class="card-body text-right ">

                <div class="col-lg-12">
                    <label for="">عنوان الخدمة </label>
                    <span class="form-control">{{$client->name}}</span>
                </div>


                <div class=" my-25 p-2">
                    <label for="">صورة تعبيرية </label>
                    <div class="d-flex">
                        <img src="{{$client->image}}"
                             id="account-upload-img" class="uploadedAvatar rounded me-50"
                             alt="profile image" height="100" width="100"/>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('site.lawyer.electronic-office.dashboard.clients.index',$id)}}"
                       class="btn btn-secondary"> رجوع </a>
                </div>

            </div>
        </div>

    </div>
@endsection
