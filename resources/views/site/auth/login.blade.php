@extends('site.layouts.main')
@section('title', 'تسجيل الدخول')
@section('content')
    <style>

    </style>
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Form Column-->
                <!--Form Column-->
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title text-center">
                        <h2>تسجيل دخول </h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form method="post" action="{{ route('site.client.post.login') }}" id="login_form">
                            @csrf

                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    @if (Session::get('successPostForgotPassword'))
                                        <div class="alert alert-success">{{ Session::get('successPostForgotPassword') }}
                                        </div>
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
                                        <label for="">اختر نوع الحساب الخاص بك</label>
                                        <select class="form-control select2" name="user_type" id="user_type" required>
                                            <option value="">نوع الحساب الخاص بك</option>
                                            <option value="2">طالب خدمة</option>
                                            <option value="1">مقدم خدمة</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">رقم الهاتف / البريد الالكتروني</label>
                                        <input class="form-control" type="text" name="credential1" id="credential1"
                                            value="" placeholder="ادخل رقم الهاتف او البريد الالكتروني" required>
                                        <span style="display: block;text-align: right;"
                                            class="text-danger error-text email_err"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for=""> كلمة المرور</label>
                                        <input required type="password" name="password" id="password" value=""
                                            class="form-control" placeholder=" يرجى تأكيد كلمة المرور هنا">
                                        <span style="display: block;text-align: right;"
                                            class="text-danger error-text password_err"></span>
                                    </div>


                                    <div style="width: 100%" class="pull-left">
                                        <div class="pull-right">
                                            <input type="checkbox" name="remember_me" id="remember_me">
                                            <label for="remember_me">
                                                تذكرني
                                            </label>
                                        </div>
                                        <a href="{{ env('REACT_WEB_LINK') . '/auth/userTypeSelection' }}" target="_blank"
                                            class="frgt-pswd pull-left" style="color: #dd9b25">
                                            نسيت كلمة المرور ؟</a>
                                    </div>


                                </div>
                                <div class="col-lg-3"></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <div class="clearfix text-center">
                                        <div style="width: 100%" class="form-group pull-left">
                                            <button id="activate_client_btn" type="submit"
                                                class="theme-btn btn-style-three"><span class="txt">
                                                    سجل هنا
                                                </span>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="clearfix text-center">
                                        <div style="width: 100%" class="form-group pull-left">
                                            <span> أليس لديك حساب ؟</span> <a data-bs-toggle="modal"
                                                data-bs-target="#choose_user_type_modal"
                                                style="color: black ; font-weight: bold">إنشاء
                                                حساب !</a>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>


                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <div class="modal fade text-start" id="choose_user_type_modal" tabindex="-1" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title " id="myModalLabel33"> يرجى اختيار نوع الحساب </h4>
                    <div style="width: 20%" class=" pull-left">
                        <button type="button" class="btn-close pull-left" data-bs-dismiss="modal"
                            aria-label="Close"></button>

                    </div>
                </div>

                <div class="modal-body text-center">


                    <div class="">
                        <a style="padding: 15px 30px; " class="theme-btn btn-style-three"
                            href="{{ route('site.client.show.register.form') }}">
                            <span class="txt" style="font-size: 15px">
                                طالب خدمة
                            </span>
                        </a>

                    </div>

                    <div class="">
                        <a style="padding: 15px 30px; " class="theme-btn btn-style-three"
                            href="{{ route('site.lawyer.show.register.form') }}">
                            <span class="txt" style="font-size: 15px">
                                مقدم خدمة
                            </span>
                        </a>

                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection
@section('site_scripts')
    <script>
        $('#user_type').on('change', function() {
            let value = $(this).val();
            if (value == 1) {
                $('#login_form').attr('action', '{{ route('site.lawyer.post.login') }}');
            } else if (value == 2) {
                $('#login_form').attr('action', '{{ route('site.client.post.login') }}');
            } else {
                $('#login_form').attr('action', '{{ route('site.client.post.login') }}');
            }
        });
    </script>
@endsection
