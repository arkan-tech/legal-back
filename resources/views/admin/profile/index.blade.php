@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            <div class="content-body">
                <div class="row">
                    <div class="col-12">

                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.profile.update')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> تعديل بيانات </h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <div class="col-12 col-md-12 mb-1">
                                            <label for="name" class="form-label">الاسم</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}" />
                                        </div>
                                    <div class="col-12 col-md-12 mb-1">
                                            <label for="login-email" class="form-label">الايميل</label>
                                            <input type="text" class="form-control" id="login-email" name="email" value="{{auth()->user()->email}}" aria-describedby="login-email" tabindex="1" autofocus />
                                        </div>
                                        <div class="col-12 col-md-12 mb-1">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="login-password">كلمة المرور</label>
                                            </div>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                            @error('password')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror


                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ
                                </button>
                                <a href="{{route('admin.home')}}" type="reset"
                                   class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </a>
                            </div>
                        </form>
                        <!--/ form -->


                    </div>

                </div>


            </div>
        </div>
    </div>

    <!-- END: Content-->
@endsection
