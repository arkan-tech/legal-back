@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 15% ;margin-bottom: 15%">
                <h1> لوحة تحكم </h1>
            </div>
        </div>
        <section class="page-banner">
            <div class="image-layer"></div>
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1></h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a></a></li>
                                <li class="active"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!---end header-->
@endsection
@section('electronic_office_content')

    <div class="auto-container row " style="max-width: 100%">

        <!--Login Form-->
        @include('site.lawyers.electronic_office.dashboard.layouts.side_menue',['id'=>$id])

        <div class="col-lg-9  mt-3 mb-3">

            <div class="card-body text-right ">
                <div class="card-header border-bottom">
                    <h4 class="card-title">معلومات الشخصية</h4>
                </div>
                <div class=" my-25 p-2">
                    <div class="d-flex">
                        <img src="{{$lawyer->photo}}"
                             id="account-upload-img" class="uploadedAvatar rounded me-50"
                             alt="profile image" height="100" width="100"/>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label" for="accountFirstName"> الاسم </label>
                        <span type="text" class="form-control">{{$lawyer->name}}</span>
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="accountEmail"> كود الدولة</label>
                        <span type="text" class="form-control">{{'+'.$lawyer->phone_code}}</span>
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="accountEmail">رقم الجوال</label>
                        <span type="text" class="form-control">{{$lawyer->phone}}</span>
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label" for="accountEmail">تاريخ الميلاد</label>
                        <span type="text" class="form-control">{{$lawyer->birthday}}</span>
                    </div>

                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label" for="accountEmail"> الجنس</label>
                        <span type="text" class="form-control">{{$lawyer->gender}}</span>
                    </div>
                    <div class="col-12 col-sm-12 mb-1">
                        <label class="form-label" for="accountEmail">تعريف مختصر :</label>
                        <textarea class="form-control" rows="5" disabled>
                                                {{$lawyer->about}}
                                            </textarea>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
