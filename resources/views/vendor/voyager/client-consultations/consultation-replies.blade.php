@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop



@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i>

        {{ __('voyager::generic.Consultation-replies') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')

@section('content')


<style>
    .m-widget1 .m-widget1__item .m-widget1__number{
        font-size: 1rem;
        font-weight: 500
    }
    .profile-status {
        font-size: 1.2em;
        margin-top: -10px;
        padding-bottom: 10px;
        color: #8bc34a;
    }
    .booking-status.completed {
        color: #008000;
        text-align: left;
    }
    .user-phone{
        font-size: 1.2em;
    }
    .m-timeline-1__item.m-timeline-1__item--right .m-timeline-1__item-time {
        right: 3.57rem;
    }
    .m-timeline-1__item-actions{
        text-align: left;
    }
   .m-timeline-1__item-time{
        color: #FADC2E !important;
        font-size: 1.9em;
        left: 0px !important;
        position: absolute;
        top: -35px;
        width: 100%;
    }
    .booking-status.accepted {
        color: #800080;
        text-align: left;
    }
    .booking-status.pending {
        color: #90a4ae;
        text-align: left;
    }
    .view-more {
        background-color: #FADC2E !important;
        border-color: #30353B !important;
        border: none;
        padding: 10px 12px;
        border-bottom: 3px solid;

        transition: border-color 0.1s ease-in-out 0s, background-color 0.1s ease-in-out 0s;
        border-radius: 3px;
        background-clip: padding-box;
    }

    .view-more:hover{
        background-color: #30353B !important;
        border-color: #FADC2E !important;

    }

    .booking-status.driver-canceled {
        color: #008b8b;
        text-align: left;
    }
    .booking-status.user-canceled {
        color: #ff0000;
        text-align: left;
    }

    .m-timeline-1__item {
        position: relative;
        margin-right: 0;
        width: 50%;
        min-height: 3rem;
    }
    .m-timeline-1__item-content {
        background-color: #F7F8FC;
    }

    .m-timeline-1__item.m-timeline-1__item--right {
        right: 50%;
        padding-right: 2.86rem;
        top: -1rem;
    }
    .m-timeline-1__item .m-timeline-1__item-circle {
        background: white;
        width: 1.43rem;
        height: 1.43rem;
        border-radius: 50%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        z-index: 1;
        position: absolute;
    }
    .m-timeline-1__item.m-timeline-1__item--right .m-timeline-1__item-circle {
        top: 1.55rem;
        right: 0;
        -webkit-transform: translate(46%, 0);
        transform: translate(46%, 0);
    }
    .m-timeline-1__item-circle>div {
        border-radius: 50%;
        width: 0.4rem;
        height: 0.4rem;
    }

    .m--bg-danger {
        background-color: #f4516c !important;
    }
    .m-timeline-1__item-arrow:before {
        display: inline-block;
        font-family: "Metronic";
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        line-height: 0px;
        text-decoration: inherit;
        text-rendering: optimizeLegibility;
        text-transform: none;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        font-smoothing: antialiased;
        content: "";
    }
    .m-timeline-1__item-arrow:before {
        position: relative;
        top: 0;
        margin-top: 20px;
        font-size: 40px;
    }
    .m-timeline-1__item-content {
        position: relative;
        border-radius: 1.07rem;
        padding: 2.14rem;
    }
    .m-timeline-1__item-title {
        font-size: 1.1rem;
        font-weight: 500;
    }
    .booking-status.driver-canceled {
        color: #008b8b;
        text-align: left;
    }
    .m-timeline-1::after {
        background-color: #E6EAF5;
    }
    .m-timeline-1:after {
        content: '';
        position: absolute;
        width: 0.4rem;
        top: 65px;
        bottom: 3rem;
        right: 50%;
        margin-right: -0.142rem;
    }
    .m-timeline-1__item.m-timeline-1__item--left {
        right: 0;
        padding-left: 2.85rem;
    }
    .m-timeline-1__marker {
        width: 1.43rem;
        height: 0.37rem;
        border-radius: 0.36rem;
        position: absolute;
        right: 50%;
        -webkit-transform: translate(46%, 0);
        transform: translate(46%, 0);
        background-color: #E6EAF5;
    }
    .m-timeline-1__item.m-timeline-1__item--left .m-timeline-1__item-circle {
        left: 0;
        -webkit-transform: translate(-54%, 0);
        transform: translate(-54%, 0);
        top: 1.57rem;
    }
    .btn-outline-brand {
        color: #22b9ff !important;
        border-color: #22b9ff !important;
    }
</style>

@if(Session::has('success'))
<div class="page-content edit-add container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        </div>
    </div>
</div>
@endif


<div class="page-content edit-add container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="panel panel panel-bordered panel-warning">
                    <div class="panel-body">
                        <img src="https://khadamat.i-sources.com/storage/users/default.png"
                        style="width:140px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">

                        <p>
                            <i class="fa fa-user"></i> {{ $user->myname }}
                        </p>

                        <p>
                            <i class="fa fa-envelope"></i> {{ $user->email }}
                        </p>

                        <p>
                            <i class="fa fa-mobile"></i> {{ $user->mobil }}
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel panel-bordered panel-warning">
                    <div class="alert alert-warning">
                        {{ $consultation->description }}
                    </div>
                    <div class="panel-body" style="padding: 60px 20px 20px">
                        <div class="m-timeline-1">
                                <div class="m-timeline-1__marker"></div>
<?php
$i = 0;
$counter = 0;
if ($consultation_replies) {
    foreach ($consultation_replies as $user_request) {
        $counter += 1;
        if ($counter == 1) {
            $class1 = "m-timeline-1__item--left";
        } elseif ($counter == 2) {
            $class1 = "m-timeline-1__item--right";
            $counter = 0;
        }

        if ($i == 0) {
            $class = "m-timeline-1__item--first";
        } else {
            $class = "";
        }

        ?>

                                        <div class="m-timeline-1__item <?=$class1;?> ">
                                            <div class="m-timeline-1__item-circle">
                                                <div class="m--bg-danger"></div>
                                            </div>
                                            <!--<div class="m-timeline-1__item-arrow"></div>-->
                                            <span class="m-timeline-1__item-time m--font-brand">
                                                {{ date("H:i A", strtotime($user_request->created_at)) }}
                                            </span>
                                            <div class="m-timeline-1__item-content">
                                                <div class="m-timeline-1__item-title">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <h2 style="font-size: 15px">
                                                                {{ date("Y-m-d", strtotime($user_request->created_at)) }}
                                                            </h2>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="booking-status driver-canceled">
                                                                <i class="fa fa-circle"></i>
                                                                <span>
                                                                    @if($user_request->from == 2)
                                                                        الإدارة
                                                                    @elseif($user_request->from == 1)
                                                                        العميل
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="row">-->
                                                    <!--    <div class="col-lg-12">-->
                                                    <!--        <h4 class="user-phone"></h4>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->

                                                    <!-- <div class="row">
                                                        <div class="col-lg-12">
                                                            <p class="">
                                                                <b>
                                                                    {{-- ($user_request->service) ? $user_request->service->name : "" --}}
                                                                </b>
                                                            </p>
                                                        </div>
                                                    </div> -->

                                                    <div class="row">
                                                        <div class="col-lg-12">

                                                            <b>
                                                                {{ $user_request->reply }}
                                                            </b>

                                                        </div>
                                                    </div>
                                                </div>
                                                {{--<div class="m-timeline-1__item-actions">
                                                    <p class="btn btn-sm btn-outline-brand m-btn m-btn--pill m-btn--custom">
                                                        @if($user_request->payment_status == 1)
                                                            تم الدفع بنجاح
                                                        @elseif($user_request->payment_status == 2)
                                                            تم الرفض
                                                        @elseif($user_request->payment_status == 2)
                                                            تم الغاء الدفع
                                                        @else
                                                            حالة الدفع غير محددة
                                                        @endif
                                                    </p>
                                                </div>--}}
                                            </div>
                                        </div>

                                <?
    }
}
?>
                            <div class="clearfix">
                                <a class="view-more btn btn-primary pull-right" href="/admin/client-consultations/add-reply/<?=$consultation->id;?>">
                                    اضافة رد جديد
                                </a>
                            </div>
</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@stop