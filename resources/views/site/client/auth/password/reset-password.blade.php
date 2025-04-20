@extends('site.layouts.main')
@section('title','نسيت كلمة المرور')
@section('content')

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">

                <!--Form Column-->

                <!--Form Column-->
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <h2> ادخل كلمة المرور الجديدة </h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form method="post" action="{{ route('site.client.post-reset-password', $key) }}">
                            @csrf

                            @if (Session::get('resetError'))
                                <div class="alert alert-danger">{{ Session::get('resetError') }}</div>
                            @endif

                            <p>
                                {{ $errors->first('password') }}
                            </p>

                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-user"></span></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="كلمة المرور الجديدة" required>
                            </div>

                            <div class="clearfix">
                                <div style="width: 100%" class="form-group pull-left">
                                    <button type="submit" class="theme-btn btn-style-three"><span class="txt">
                                            تأكيد كلمة المرور
                                        </span></button>
                                </div>
                                <div class="form-group submit-text pull-right">
                                    لا يجوز لك استخدام، أو حث الآخرين على استخدام، أي نظام مميكن أو برنامج إلكتروني لاستخراج محتوى أو بيانات من موقعنا الإلكتروني باستثناء الحالات التي تدخل فيها أنت شخصياً، أو يدخل فيها أي طرف ثالث معني طرفاً في اتفاق خطي معنا يُجيز هذا الفعل صراحة.
                                </div>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
