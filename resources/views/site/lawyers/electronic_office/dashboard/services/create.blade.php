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

    <div class="row " style="max-width: 100%">

        <!--Login Form-->
        @include('site.lawyers.electronic_office.dashboard.layouts.side_menue')

        <div class="col-lg-9  mt-3 mb-3">


            <div class="card-header border-bottom">
                <h4 class="card-title text-center"> اضافة خدمة جديدة </h4>
            </div>


            <div class="card-body text-right ">
                <form class="form row" method="post"
                      action="{{route('site.lawyer.electronic-office.dashboard.services.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="electronic_id_code" value="{{$id}}">
                    <div class="col-lg-12">
                        <label for="">عنوان الخدمة </label>
                        <input type="text" name="title" class="form-control @error('title')is-invalid @enderror">
                        @error('title')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">سعر الخدمة </label>
                        <input type="number" name="price" class="form-control @error('price')is-invalid @enderror">
                        @error('price')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-lg-12 mt-1">
                        <label for="">وصف الخدمة </label>
                        <textarea name="description" rows="4"
                                  class="form-control  @error('description')is-invalid @enderror"></textarea>
                        @error('description')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label for="">صورة تعبيرية </label>
                        <input name="image" type="file" class="form-control @error('image')is-invalid @enderror"
                               accept=".png , .jpeg , .jpg">
                        @error('image')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" style="background-color: #dd9b25"> حفظ</button>
                        <a href="{{route('site.lawyer.electronic-office.dashboard.services.index',$id)}}"
                           class="btn btn-secondary"> رجوع </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
