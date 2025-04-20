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
                        <div class="separate"></div>
                    </div>
                    <!--Login Form-->
                    <div class="styled-form register-form">

                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                <div class="row">
                                    <div class="col-lg-6 text-right pt-3 ">
                                        <span class="txt">{{ Session::get('success') }}  </span>
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
