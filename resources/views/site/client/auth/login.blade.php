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
                        <form action="{{ route('site.client.post.login') }}" method="post">
                            @csrf
                            @if (Session::get('successPostForgotPassword'))
                                <div class="alert alert-success">{{ Session::get('successPostForgotPassword') }}</div>
                            @endif
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
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
                                        <a style="color: #dd9b25"
                                            href="{{ env('REACT_WEB_LINK') . '/auth/userTypeSelection' }}"
                                            class="frgt-pswd ">نسيت كلمة المرور؟</a>
                                    </div>
                                    <a style="color: #dd9b25" href="{{ route('site.client.show.register.form') }}"
                                        class="frgt-pswd pull-left">
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
