@extends('site.layouts.main')
@section('title', 'تسجيل الدخول')
@section('content')

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Form Column-->
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <div class="separate"></div>
                    </div>
                    <!--Login Form-->
                    <div class="styled-form register-form">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('activate-email'))
                            <div class="alert alert-warning">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt">
                                            حسابك يحتاج الى تأكيد الايميل ,</span>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <a style="background-color: #FFE649"
                                            href="{{ route('site.lawyer.profile.edit', \Illuminate\Support\Facades\Session::get('waiting')) }}"
                                            target="_blank" class="theme-btn  btn-style-three"
                                            style="background-color: #FFE694">
                                            <span class="txt" style="color: black">اضغط هنا لمراجعة بياناتك </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Session::has('waiting'))
                            <div class="alert alert-warning">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt">
                                            تم تحويل حالة حسابك إلى حالة <span class="mr-1 ml-1"
                                                style="font-weight: bold">الانتظار</span> ويجرى الآن مراجعة بياناتك حتى يتم
                                            اعتمادها </span>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <a style="background-color: #FFE649"
                                            href="{{ route('site.lawyer.profile.edit', \Illuminate\Support\Facades\Session::get('waiting')) }}"
                                            target="_blank" class="theme-btn  btn-style-three"
                                            style="background-color: #FFE694">
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
                                        <span class="txt"> حسابكم لا زال في قائمة انتظار الاعتماد , و سوف يتم إشعاركم
                                            برسالة بريدية عند اعتماده , شكرا لكم . </span>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <a style="background-color: #FFE649"
                                            href="{{ env('REACT_WEB_LINK') . '/contact-us' }}" target="_blank"
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


                        @if (Session::has('profile_complete'))
                            <div class="alert alert-danger">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt"> نأسف يجب عليك اكمال معلوماتك حتى تتمكن من الاستفادة من الخدمات
                                            ,

                                        </span>
                                        <div class="col-lg-6 text-left">
                                            <a style="background-color: #FFE649"
                                                href="{{ route('site.lawyer.profile.edit', \Illuminate\Support\Facades\Session::get('profile_complete')) }}"
                                                target="_blank" class="theme-btn  btn-style-three"
                                                style="background-color: #FFE694">
                                                <span class="txt" style="color: black">اضغط هنا لمراجعة بياناتك </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <a href="{{ env('REACT_WEB_LINK') . '/contact-us' }}" target="_blank"
                                            class="theme-btn  btn-style-one" style="background-color: #F1AEC1">
                                            <span class="txt" style="color: black">مراسلة الإدارة </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
