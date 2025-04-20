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
                              action="{{route('admin.library.category.store')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">القسم الرئيسي</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf

                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">اسم القسم الرئيسي </label>
                                            <input type="text"
                                                   class="form-control @error('main_cat_title')is-invalid @enderror"
                                                   name="main_cat_title" required/>
                                            @error('main_cat_title')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">صورة القسم الرئيسي </label>
                                            <input type="file"
                                                   class="form-control @error('main_cat_image')is-invalid @enderror"
                                                   name="main_cat_image"  accept=".png,.jpg,.jpeg" required/>
                                            @error('main_cat_image')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">  وصف قصير </label>
                                            <input type="text"
                                                   class="form-control @error('main_cat_description')is-invalid @enderror"
                                                   name="main_cat_description" required/>
                                            @error('main_cat_description')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-body sub_category">
                                <div class="card-header">
                                    <h4 class="card-title"> اقسام فرعية</h4>
                                </div>
                                <div data-repeater-list="sub_category">
                                    <div data-repeater-item>
                                        <div class="row d-flex align-items-end">
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                        <label class="form-label" for="itemname"> اسم القسم الفرعي </label>
                                                    <input type="text" class="form-control" name="title"
                                                           aria-describedby="itemname" required
                                                           placeholder="عنوان العنوان الفرعي "/>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                        <label class="form-label" for="itemname"> وصف قصير </label>
                                                    <input type="text" class="form-control" name="description"
                                                           aria-describedby="itemname" required
                                                           placeholder=" وصف قصير "/>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="itemname">  صورة القسم الفرعي </label>
                                                    <input type="file" class="form-control" name="image" accept=".png,.jpg,.jpeg"
                                                           aria-describedby="itemname" required
                                                        />
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12 mb-50">
                                                <div class="mb-1">
                                                    <button class="btn btn-outline-danger text-nowrap px-1"
                                                            data-repeater-delete type="button">
                                                        <i data-feather="x" class="me-25"></i>
                                                        <span>ازالة</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                            <i data-feather="plus" class="me-25"></i>
                                            <span> اضافة قسم فرعي جديد</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ
                                </button>
                                <a href="{{route('admin.library.category.index')}}" type="reset"
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
@section('scripts')

    <script>
        $('.sub_category').repeater({
            show: function () {
                $(this).slideDown();
                // Feather Icons
                if (feather) {
                    feather.replace({width: 14, height: 14});
                }
            },
            hide: function (deleteElement) {
                if (confirm('هل انت متأكد من حذف القسم الفرعي؟')) {
                    $(this).slideUp(deleteElement);
                }
            }

        });
    </script>
@endsection
