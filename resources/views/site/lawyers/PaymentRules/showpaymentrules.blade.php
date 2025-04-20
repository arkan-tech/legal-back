<style>
    .designation{
        text-align: justify
    }
    .price-block .inner-box .price {
        font-size: 35px !important;
    }
    .price-block .inner-box .price:before {
        bottom: -5px !important
    }
    .price-block .inner-box:hover .intro{
        color:#ffffff;
    }
    .modal-footer{
        padding-top: 0px;
        border-top: 0px;
    }
    .price-block .inner-box:hover .intro p{
        color:#ffffff;
    }
    .modal-footer .btn-default{
        background: #fa2a00;
        color: #fff;
        border: 0;
        border-radius: 3px;
        opacity: .9;
    }
    .prticipate{
        font-size: 1rem;
        font-weight: 400;
        padding: 3px 10px !important;
        border-radius: 3px !important;
        margin-left: 5px !important
    }
</style>
@extends('site.layouts.main')
@section('title', 'باقات الدليل الرقمي')
@section('content')

    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <h2> باقات الدليل الرقمي </h2>
                        <div class="separate"></div>
                    </div>
                    <!--Login Form-->
                    <div class="styled-form register-form">

                        <div class="row">

                            @include('site.lawyer_right_menu', array('lawyer'=> $lawyer))

                            <div class="row col-lg-10 col-md-12 col-sm-12">

                                @foreach($packages as $package)
                                    <div class="price-block col-lg-6 col-md-6 col-sm-12">
                                        <div class="inner-box" style="background-image:url('{{asset('site/images/background/pattern-7.png')}}')">
                                            <div class="color-one-layer"></div>
                                            <div class="color-two-layer"></div>
                                            <div class="side-icon flaticon-civil-right"></div>
                                            <div class="price">
                                                <span>{{$package->title}}</span>
                                                <div class="intro text-justify">
                                                    {!! $package->intro !!}
                                                </div>
                                                {{ $package->price }} ريال
                                            </div>
                                            <a style="color: #fff" data-toggle="modal" data-target="#ofiice-package-{{$package->id}}" class="theme-btn btn-style-four">
                                                <span class="txt"> اشترك فى الباقة </span>
                                            </a>
                                            <div id="ofiice-package-{{$package->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel"> الشروط والأحكام </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                {!! $package->rules !!}
                                                            </p>
                                                            <p class="text-right">
                                                                <input type="checkbox" class="checkbox-parent"> <b>الموافقة على الشروط والأحكام</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="#" class="theme-btn btn-style-four prticipate office-participate">
                                                                {{--                                            <a href="/buy-package/{{ $package->id }}" class="theme-btn btn-style-four prticipate office-participate">--}}
                                                                <span class="txt"> اشتراك </span>
                                                            </a>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--
                                            <a href="/buy-package/{{ $package->id }}" class="theme-btn btn-style-four">
                                                <span class="txt"> اشترك فى الباقة </span>
                                            </a>
                                            --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('.checkbox-parent').change(function() {
                var $child = $(this).parent('.text-right').parent('.modal-body').next('.modal-footer').find('.office-participate');
                $child.unbind('click', false);
            });
            $(function(){
                $('.office-participate').bind('click', false);
            });
        });
    </script>



@endsection
