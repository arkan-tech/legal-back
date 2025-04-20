@extends('site.layouts.main')
@section('title','استعادة كلمة المرور ')
@section('content')
    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Form Column-->
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <h2> ادخل بريدك الإلكترونى </h2>
                        <div class="separate"></div>
                    </div>
                    @if (Session::get('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form method="post" action="{{route('site.lawyer.password.post-forgot')}}">
                            @csrf

                            @if (Session::get('not-found-user'))
                                <div class="alert alert-danger">{{ Session::get('not-found-user') }}</div>
                            @endif
                            <p>
                                {{ $errors->first('email') }}
                            </p>

                            <div class="form-group" >
                                <span class="adon-icon"><span class="fa fa-user"></span></span>
                                <input type="text" name="email" id="email" class="form-control" value="" placeholder="البريد الإلكترونى" required>
                            </div>

                            <div class="clearfix">
                                <div style="width: 100%" class="form-group pull-left">
                                    <button type="submit" class="theme-btn btn-style-three"><span class="txt">
                                            ارسال كلمة المرور
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
