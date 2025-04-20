@extends('site.layouts.main')
@section('title','تفعيل الحساب')
@section('content')
    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Form Column-->
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <h2> ادخل بريدك الإلكترونى و الرمز</h2>
                        <div class="separate"></div>
                    </div>
                    @if (Session::get('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form method="post" action="{{route('site.lawyer.show.activate.check')}}">
                            @csrf

                            @if (Session::get('not-found-user'))
                                <div class="alert alert-danger">{{ Session::get('not-found-user') }}</div>
                            @endif
                            <p>
                                {{ $errors->first('email') }}
                            </p>

                            <p>
                                {{ $errors->first('otp') }}
                            </p>

                            <div class="form-group" >
                                <label for="">البريد الاكتروني</label>
                                <input type="text" name="email" id="email" class="form-control" value="" placeholder="البريد الإلكترونى" required>
                            </div>

                            <div class="form-group" >
                                <label for=""> الرمز</label>
                                <input type="text" name="otp"
                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       maxlength="4" id="otp" class="form-control" value="" placeholder="الرمز" required>
                            </div>

                            <div class="clearfix">
                                <div style="width: 100%" class="form-group pull-left">
                                    <button type="submit" class="theme-btn btn-style-three"><span class="txt">
                                            تفعيل الحساب
                                        </span>
                                    </button>
                                </div>

                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
