@extends('site.layouts.main')
@section('title',' حسابى الشخصى ')
@section('content')

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Login Form-->
                <div class="row">
                    @include('site.lawyer_right_menu')
                    <div class="col-lg-9">
                        <div class="col-lg-12 ">
                            <div class="card">
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
                                <div class="col-lg-12 row mt-1">
                                    <div class="col-lg-4 col-sm-4 mb-1">
                                        <label class="form-label" for="accountEmail">الجنسية </label>
                                        <span type="text" class="form-control">{{$nationality->name}}</span>

                                    </div>
                                    <div class="col-lg-4 col-sm-4 mb-1">
                                        <label class="form-label" for="accountEmail">الدولة </label>
                                        <span type="text" class="form-control">{{$countries->name}}</span>

                                    </div>
                                    @if(!is_null($regions))
                                    <div class="col-lg-4 col-sm-4 mb-1">
                                        <label class="form-label" for="accountEmail">المنطقة </label>
                                        <span type="text" class="form-control">{{$regions->name}}</span>

                                    </div>
                                        @endif

                                    @if(!is_null($cities))
                                        <div class="col-lg-4 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">المدينة </label>
                                            <span type="text" class="form-control">{{$cities->title}}</span>

                                        </div>
                                        @endif

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
