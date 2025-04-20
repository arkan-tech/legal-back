@extends('site.layouts.main')
@section('title',' حسابى الشخصى ')
@section('content')

<style>
	.designation{
		text-align: justify
	}
    .price-block .inner-box .intro {
        font-size: 16px !important;
        line-height: 30px !important
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

    .price-block .inner-box:hover .intro p{
        color:#ffffff;
    }
    /* .modal-header{
        border-bottom: 0px;
    } */
    .modal-footer{
        padding-top: 0px;
        border-top: 0px;
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

<!-- Contact Form Section -->
<section class="register-section" style="padding: 50px 0px 20px">
    <div class="auto-container">
        <div class="row clearfix justify-content-md-center">

        <div class="form-column column col-lg-8 col-md-12 col-sm-12 ">
            <div class="styled-form register-form">

                    <div class="row">
                        <div style="" class="col-lg-12 col-md-12 col-sm-12">
{{--                            <div class="alert alert-warning alert-block office-request-success" style="text-align: center">--}}
{{--                                <strong class="success-msg">--}}
{{--                                    يجب ان تقوم بالإشتراك اولا فى احدى باقاتنا لتتمكن من استخدام ملفك الشخصى .--}}
{{--                                </strong>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<!-- Team Detail Section -->
<section class="team-detail-section" style="padding: 0px 0px 0px">
    <div class="auto-container">
        <div class="upper-box">
            <div class="row clearfix">

                <div class="content-column col-lg-12 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="title"> </div>
                        <div class="name_lawyer">
                            <h2>{{ setting('site.payment_page_title') }}</h2>
                        </div>
{{--                        <div class="designation">--}}
{{--                            <?=strip_tags(setting('site.payment_page_text'));?>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section style="padding: 0px 0px 70px;" class="pricing-section digital_guide">
    <div class="auto-container">
        <div class="row clearfix">

            @foreach($packages as $package)
                <div class="price-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box" style="background-image:url(site/images/background/pattern-7.png)">
                        <div class="color-one-layer"></div>
                        <div class="color-two-layer"></div>

                        <div class="side-icon flaticon-civil-right"></div>
                        <div class="price"><span>{{$package->title}}</span>
                        <div class="intro text-justify">
                            {!! $package->intro !!}
                        </div>
                        {{ $package->price }} ريال
                    </div>

                        <a style="color: #fff" data-toggle="modal" data-target="#ofiice-package-<?=$package->id;?>" class="theme-btn btn-style-four">
                            <span class="txt"> اشترك فى الباقة </span>
                        </a>

<div id="ofiice-package-<?=$package->id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"> الشروط والأحكام </h4>
        </div>
        <div class="modal-body">
            <p>
                {{ $package->rules }}
            </p>
            <p class="text-right">
                <input type="checkbox" class="checkbox-parent"> <b>الموافقة على الشروط والأحكام</b>
            </p>
        </div>
        <div class="modal-footer">
            <a href="/buy-package/{{ $package->id }}" class="theme-btn btn-style-four prticipate office-participate">
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
</section>


<section class="team-detail-section" style="padding: 50px 0px 0px">
    <div class="auto-container">
        <div class="upper-box">
            <div class="row clearfix">

                <div class="content-column col-lg-12 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="title"> </div>
                        <div class="name_lawyer">
                            <h2>الإشتراك فى الدليل الرقمى للموقع</h2>
                        </div>
{{--                        <div class="designation">--}}
{{--                            <?=strip_tags(setting('site.digital_guide_payment_text'));?>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<section style="padding: 0px 0px 0px;" class="pricing-section digital_guide">
    <div class="auto-container">
        <div class="row clearfix">

            @foreach($digital_packages as $package)
                <div class="price-block col-lg-4 col-md-6 col-sm-12">
                    <div class="inner-box" style="background-image:url(site/images/background/pattern-7.png)">
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

                        <a style="color: #fff" data-toggle="modal" data-target="#digital-package-<?=$package->id;?>" class="theme-btn btn-style-four">
                            <span class="txt"> اشترك فى الباقة </span>
                        </a>

<div id="digital-package-<?=$package->id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"> الشروط والأحكام </h4>
        </div>
        <div class="modal-body">
            <p>
                {{ $package->rules }}
            </p>
            <p class="text-right">
                <input type="checkbox" class="checkbox-parent-2"> <b>الموافقة على الشروط والأحكام</b>
            </p>
        </div>
        <div class="modal-footer">
            <a href="/digital-guide-subscription/{{ $lawyer->id }}/{{ $package->id }}" class="theme-btn btn-style-four prticipate digital-participate">
                <span class="txt"> اشتراك </span>
            </a>

            <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق </button>

        </div>
        </div>
    </div>
</div>

                        {{--
                        <a href="/digital-guide-subscription/{{ $lawyer->id }}/{{ $package->id }}" class="theme-btn btn-style-four">
                            <span class="txt"> اشترك فى الباقة </span>
                        </a>--}}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>



<script>
    $(document).ready(function() {
        $('.checkbox-parent').change(function() {
            var $child = $(this).parent('.text-right').parent('.modal-body').next('.modal-footer').find('.office-participate');
            $child.unbind('click', false);

        });

        $('.checkbox-parent-2').change(function() {
            var $child = $(this).parent('.text-right').parent('.modal-body').next('.modal-footer').find('.digital-participate');
            $child.unbind('click', false);

        });

        $(function(){
            $('.office-participate').bind('click', false);

            $('.digital-participate').bind('click', false);
        });

    });
</script>


@endsection
