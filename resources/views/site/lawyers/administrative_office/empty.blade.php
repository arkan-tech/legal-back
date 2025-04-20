@extends('site.layouts.main')
@section('title',' المكتب الاداري')
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
                        <div class="alert alert-danger">
                            <div class="row">
                                <div class="col-lg-8 text-right pt-3 ">
                                    <span class="mr-1 ml-1" style="font-weight: bold">عذراً , انت غير مشترك في  احدى باقات المكتب الالكتروني او المكتب الاداري ,  للطلاع على باقات الدليل الرقمي انقر على الزر </span>
                                </div>
                                <div class="col-lg-4 text-left">
                                    <a href="{{route('site.lawyer.showPaymentRules')}}" target="_blank" class="theme-btn  btn-style-one" style="background-color: #F1AEC1">
                                        <span class="txt">انقر هنا للاطلاع على باقات الدليل الرقمي   </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
