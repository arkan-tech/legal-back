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
            <div class="card-header border-bottom">
                <h4 class="card-title">معلومات الشخصية</h4>
            </div>

            <form action="{{route('site.lawyer.electronic-office.dashboard.settings.update')}}" method="post" enctype="multipart/form-data">

            <div class="card-body text-right ">
                @if(Session::has('success'))
                    <div class="alert alert-primary" role="alert">
                        <div class="alert-body">
                            {{Session::get('success')}}
                        </div>
                    </div>
                @endif
                    @csrf
                    <input type="hidden" value="{{$id}}" name="electronic_id_code">
                <div class=" my-25 p-2">
                    <div class="d-flex">
                        <img src="{{$lawyer->photo}}"
                             id="account-upload-img" class="uploadedAvatar rounded me-50"
                             alt="profile image" height="100" width="100"/>
                    </div>

                </div>
                <input type="file" name="personal_image" class="form-control">
                <div class="row p-2">
                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label" for="accountFirstName"> الاسم </label>
                        <input type="text" name="name" class="form-control  @error('name')is-invalid @enderror" value="{{$lawyer->name}}"/>
                        @error('name')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label" for="accountEmail">رقم الجوال</label>
                        <input type="number" name="phone" class="form-control  @error('phone')is-invalid @enderror " value="{{$lawyer->phone}}">
                        @error('phone')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-lg-12 row">
                        <label> تاريخ الميلاد :</label>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> يوم :</label>
                                <input type="number" name="day"
                                       class="form-control @error('day')is-invalid @enderror"
                                       value="{{$lawyer->day}}" required max="30">
                                @error('day')
                                <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> شهر :</label>
                                <select class="form-control @error('month')is-invalid @enderror" name="month" id="month" required>
                                    <option value="01" {{$lawyer->month =='01'?'selected':''}}>كانون الثاني
                                        (يناير)
                                    </option>
                                    <option value="02" {{$lawyer->month =='02'?'selected':''}}>شباط (فبراير)
                                    </option>
                                    <option value="03" {{$lawyer->month =='03'?'selected':''}}>آذار (مارس)
                                    </option>
                                    <option value="04" {{$lawyer->month =='04'?'selected':''}}>نيسان (أبريل)
                                    </option>
                                    <option value="05" {{$lawyer->month =='05'?'selected':''}}>آيار (مايو)
                                    </option>
                                    <option value="06" {{$lawyer->month =='06'?'selected':''}}>حزيران (يونيو)
                                    </option>
                                    <option value="07" {{$lawyer->month =='07'?'selected':''}}>تموز (يوليو)
                                    </option>
                                    <option value="08" {{$lawyer->month =='08'?'selected':''}}>آب (أغسطس)
                                    </option>
                                    <option value="09" {{$lawyer->month =='09'?'selected':''}}>أيلول (سبتمبر)
                                    </option>
                                    <option value="10" {{$lawyer->month =='10'?'selected':''}}>تشرين الأول
                                        (أكتوبر)
                                    </option>
                                    <option value="11" {{$lawyer->month =='11'?'selected':''}}>تشرين الثاني
                                        (نوفمبر)
                                    </option>
                                    <option value="12" {{$lawyer->month =='12'?'selected':''}}>كانون الأول
                                        (ديسمبر)
                                    </option>
                                </select>
                                @error('month')
                                <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label> سنة :</label>
                                <input type="number" name="year" id="year"
                                       class="form-control  @error('year')is-invalid @enderror"
                                       value="{{$lawyer->year}}" required>
                                @error('year')
                                <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label"> الجنس :</label>
                        <select id="gender" name="gender"
                                class="form-control @error('gender')is-invalid @enderror  ">
                            <option value="">اختر</option>
                            <option {{$lawyer->gender ==='Male' ?'selected' :''}} value="Male">ذكر
                            </option>
                            <option {{$lawyer->gender==='Female' ?'selected' :''}} value="Female">أنثى
                            </option>
                        </select>
                        @error('gender')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-12 col-sm-12 mb-1 mt-3">
                        <label class="form-label" for="accountEmail">تعريف مختصر :</label>
                        <textarea class="form-control @error('about')is-invalid @enderror" rows="5" name="about" >
                                                {{$lawyer->about}}
                                            </textarea>
                        @error('about')
                        <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-12 col-sm-12 mb-1 mt-3">
                        <div class="form-group">
                            <label> البريد الالكتروني </label>
                            <input type="email" name="email" id="email" value="{{$lawyer->email}}"
                                   class="form-control @error('email')is-invalid @enderror "
                                   placeholder="البريد الالكتروني">
                            @error('email')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>

                    </div>
                    <div class="col-12 col-sm-12 mb-1 mt-3">
                        <div class="form-group">
                            <label> كلمة المرور </label>
                            <input type="password" name="password" id="password"
                                   class="form-control  @error('password')is-invalid @enderror "
                                   placeholder="كلمة المرور">
                            @error('password')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" style="background-color: #dd9b25"> حفظ</button>
                <a href="{{route('site.lawyer.electronic-office.dashboard.settings.index',$id)}}"
                   class="btn btn-secondary"> رجوع </a>
            </div>
            </form>

        </div>

    </div>
@endsection
