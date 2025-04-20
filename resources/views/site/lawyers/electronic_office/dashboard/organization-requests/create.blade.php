@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 15% ;margin-bottom: 15%">
                <h2> لوحة التحكم </h2>
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
            <section class="text-right">
                <div class="auto-container">
                    <div class="styled-form register-form" style="margin-top: 25px;">
                        <form id="make-service-request"
                              action="{{route('site.lawyer.electronic-office.dashboard.organization-request.store')}}"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{$lawyer->id}}" name="lawyer_id">
                            <input type="hidden" value="{{$id}}" name="electronic_id_code">
                            <div class="form-group">
                                            <span class="adon-icon">
                                                <span class="fa fa-cog"></span>
                                            </span>
                                <select id="type" name="type" class="form-control @error('type')is-invalid @enderror">
                                    <option value=""> الهيئة الإستشارية</option>
                                    {{GetSelectItem('advisorycommittees', 'title')}}
                                </select>
                                @error('type')
                                <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <span class="adon-icon"><span class="fa fa-cog"></span></span>
                                <select id="priority" name="priority"
                                        class="form-control @error('priority')is-invalid @enderror">
                                    <option value=""> مستوى الطلب</option>
                                    <option value="1">عاجل جدا</option>
                                    <option value="2">مرتبط بموعد</option>
                                </select>
                                @error('priority')
                                <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                            <textarea class="form-control @error('description')is-invalid @enderror"
                                                      cols="6" style="height: 150px" rows="6"
                                                      type="text" id="description" name="description" value=""
                                                      placeholder="محتوى الطلب"></textarea>
                                @error('description')
                                <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="file">المرفقات</label>
                                <input class="form-control" type="file" name="file" id="file"
                                       accept=".png,.jpg,jpeg ,.pdf">
                                <span style="display: block;text-align: right;"
                                      class="text-danger error-text file_err"></span>
                            </div>
                            <br>
                            <div class="clearfix">
                                <div class="form-group pull-right">
                                    <button style="background-color: #dd9b25" type="submit"
                                            class="theme-btn btn-style-three">
                                        <span class="txt"> تأكيد الطلب </span>
                                    </button>


                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
@section('electronic_office_site_scripts')

@endsection
