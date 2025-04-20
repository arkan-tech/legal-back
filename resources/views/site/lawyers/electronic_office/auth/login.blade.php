@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{ asset('site/electronic_office/images/services.jpg') }}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 20% ;margin-bottom: 15%">
                <h1> تسجيل الدخول </h1>
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
    <section class="auto-container" style="padding: 5%">
        <div class="row ">
            <div class="col-lg-6">
                <div>
                    <img src="{{ asset('site/images/logo.png') }}" height="100%">
                </div>
            </div>
            <div class="col-lg-6 mt-2">
                <div class="text-right about-right ">
                    <form action="{{ route('site.lawyer.electronic-office.post.login') }}" method="post">
                        @csrf
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('success-reset-password'))
                            <div class="alert alert-success">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt">{{ Session::get('success-reset-password') }}</span>
                                    </div>

                                </div>
                            </div>
                        @endif
                        @if (Session::has('waiting'))
                            <div class="alert alert-warning">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt">
                                            تم تحويل حالة حسابك الى حالة <span class="mr-1 ml-1"
                                                style="font-weight: bold">الانتظار</span> ويجرى الان مراجعة بياناتك حتى يتم
                                            اعتمادها </span>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <a href="{{ route('site.lawyer.profile.edit', \Illuminate\Support\Facades\Session::get('waiting')) }}"
                                            target="_blank" class="theme-btn  btn-style-three"
                                            style="background-color: #FFE694 ">
                                            <span class="txt" style="color: black">اضغط هنا لمراجعة بياناتك </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Session::has('waiting-accept'))
                            <div class="alert alert-warning">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt"> حسابك في انتظار الاعتماد . سوف يتم ارسال لك رسالة على الايميل
                                            عند الاعتماد , شكراً لحسن تعاونكم معنا . </span>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <a href="{{ env('REACT_WEB_LINK') . '/contact-us' }}" target="_blank"
                                            class="theme-btn  btn-style-three" style="background-color: #FFE694">
                                            <span class="txt" style="color: black">مراسلة الإدارة </span>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Session::has('blocked'))
                            <div class="alert alert-danger">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt"> نأسف , تم <span class="mr-1 ml-1"
                                                style="font-weight: bold">حظر</span> حسابك من طرف مدير المنصة </span>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <a href="{{ env('REACT_WEB_LINK') . '/contact-us' }}" target="_blank"
                                            class="theme-btn  btn-style-one" style="background-color: #F1AEC1">
                                            <span class="txt">التواصل مع الادارة </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group text-center">
                            <img src="{{ asset('site/electronic_office/images/avater.png') }}">

                        </div>
                        <div class="form-group">
                            <input type="hidden" name="electronic_id_code" value="{{ $id }}">
                            <input class="form-control" type="text" name="email" id="email" value=""
                                style="border-radius: 10px" placeholder="البريد الإلكترونى" required>
                            <span style="display: block;text-align: right;" class="text-danger error-text email_err"></span>
                        </div>
                        <div class="form-group">

                            <input type="password" name="password" id="password" value="" class="form-control"
                                style="border-radius: 10px" placeholder="كلمة المرور">
                            <span style="display: block;text-align: right;"
                                class="text-danger error-text password_err"></span>
                        </div>
                        <div class="clearfix text-center">
                            <div style="width: 100%" class="form-group pull-left">
                                <div class="pull-right">
                                    <button type="submit" class="theme-btn btn-style-three"
                                        style="background-color:#ffc107 ">
                                        <span class="txt">سجل هنا</span>
                                    </button>
                                    <br>
                                </div>

                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
