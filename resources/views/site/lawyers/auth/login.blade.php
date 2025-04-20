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
                        <h2> ادخل بياناتك هنا </h2>
                        <div class="separate"></div>
                    </div>
                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form action="{{ route('site.lawyer.post.login') }}" method="post">
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
                                                    style="font-weight: bold">الانتظار</span> ويجرى الان مراجعة بياناتك حتى
                                                يتم اعتمادها </span>
                                        </div>
                                        <div class="col-lg-6 text-left">
                                            <a href="{{ route('site.lawyer.profile.edit', \Illuminate\Support\Facades\Session::get('waiting')) }}"
                                                target="_blank" class="theme-btn  btn-style-three"
                                                style="background-color: #FFE694 ">
                                                <span class="txt" style="color: black">اضغط هنا لمراجعة بياناتك </span>
                                                {{--                                                <span class="txt">التواصل مع الادارة </span> --}}
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
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-user"></span></span>
                                <input class="form-control" type="text" name="email" id="email" value=""
                                    placeholder="البريد الإلكترونى" required>
                                <span style="display: block;text-align: right;"
                                    class="text-danger error-text email_err"></span>
                            </div>
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>
                                <input type="password" name="password" id="password" value="" class="form-control"
                                    placeholder="كلمة المرور">
                                <span style="display: block;text-align: right;"
                                    class="text-danger error-text password_err"></span>
                            </div>
                            <div class="clearfix">
                                <div style="width: 100%" class="form-group pull-left">
                                    <div class="pull-right">
                                        <button type="submit" class="theme-btn  btn-style-three">
                                            <span class="txt">سجل هنا</span>
                                        </button>
                                        <br>
                                        <a href="{{ route('site.lawyer.password.index') }}" class="frgt-pswd "
                                            style="color: #dd9b25">نسيت كلمة المرور؟</a>
                                    </div>
                                    <a href="{{ route('site.lawyer.show.register.form') }}" class="frgt-pswd pull-left"
                                        style="color: #dd9b25">
                                        انشاء حساب جديد ؟ </a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 success-fail-message">
                                        <div class="alert alert-success alert-block" style="display: none;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong class="success-msg"></strong>
                                        </div>

                                        <div class="alert alert-danger alert-block" style="display: none;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong class="error-msg"></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group submit-text pull-right">
                                    لا يجوز لك استخدام، أو حث الآخرين على استخدام، أي نظام مميكن أو برنامج إلكتروني
                                    لاستخراج محتوى أو بيانات من موقعنا الإلكتروني باستثناء الحالات التي تدخل فيها أنت
                                    شخصياً، أو يدخل فيها أي طرف ثالث معني طرفاً في اتفاق خطي معنا يُجيز هذا الفعل صراحة
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
