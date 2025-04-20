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
                              action="{{route('admin.training.store')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">

                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> العنوان </label>
                                            <input type="text"
                                                   class="form-control @error('title')is-invalid @enderror"
                                                   name="title" required/>
                                            @error('title')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> المدرب </label>
                                            <input type="text"
                                                   class="form-control @error('coach')is-invalid @enderror"
                                                   name="coach" required/>
                                            @error('coach')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> المنظم </label>
                                            <input type="text"
                                                   class="form-control @error('orgnaizer')is-invalid @enderror"
                                                   name="orgnaizer" required/>
                                            @error('orgnaizer')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الرابط </label>
                                            <input type="url"
                                                   class="form-control @error('link')is-invalid @enderror"
                                                   name="link" placeholder="https://www.google.com" required/>
                                            @error('link')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="course_date"> تاريخ </label>
                                            <input type="date"
                                                   class="form-control @error('course_date')is-invalid @enderror"
                                                   name="course_date" required/>
                                            @error('course_date')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> المكان </label>
                                            <input type="text"
                                                   class="form-control @error('location')is-invalid @enderror"
                                                   name="location" required/>
                                            @error('location')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="course_date"> السعر </label>
                                            <input type="number"
                                                   class="form-control @error('price')is-invalid @enderror"
                                                   name="price" required/>
                                            @error('price')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> صورة الاعلان </label>
                                            <input type="file"
                                                   class="form-control @error('image')is-invalid @enderror"
                                                   name="image" accept=".png , .jpg ,.jpeg" required/>
                                            @error('image')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="details"> تفاصيل </label>
                                            <textarea class="form-control @error('details')is-invalid @enderror"
                                                      rows="7"  name="details" required> </textarea>
                                            @error('details')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ
                                </button>
                                <a href="{{route('admin.training.index')}}" type="reset"
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
