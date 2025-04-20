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
                              action="{{route('admin.library.category.update')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">القسم الرئيسي</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <input type="hidden" name="id" value="{{$library_category->id}}">
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">اسم القسم الرئيسي </label>
                                            <input type="text"
                                                   class="form-control @error('main_cat_title')is-invalid @enderror"
                                                   name="main_cat_title" value="{{$library_category->title}}"/>
                                            @error('main_cat_title')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">  وصف قصير </label>
                                            <input type="text"
                                                   class="form-control @error('main_cat_description')is-invalid @enderror"
                                                   name="main_cat_description" value="{{$library_category->description}}"/>
                                            @error('main_cat_description')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">

                                            <label class="form-label" for="accountFirstName">صورة القسم الرئيسي </label>
                                            <input type="file"
                                                   class="form-control @error('main_cat_image')is-invalid @enderror"
                                                   name="main_cat_image" accept=".png,.jpg,.jpeg"/>
                                            <img class="mt-2 avatar-border" src="{{$library_category->image}}"
                                                 width="90px"
                                                 height="50%" alt="">

                                            @error('main_cat_image')
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
                                <div class="table-responsive card-datatable table-responsive pt-0">
                                    <table class="table text-center">
                                        <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>اسم</th>
                                            <th>  وصف قصير </th>
                                            <th> الصورة</th>
                                            <th>العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($library_sub_category as $sub_cat)
                                            <tr>
                                                <td>{{$sub_cat->id}}</td>
                                                <td>{{$sub_cat->title}}</td>
                                                <td>{{$sub_cat->description}}</td>
                                                <td>
                                                    <img src="{{$sub_cat->image}}" width="70px"
                                                         height="20%">
                                                </td>
                                                <td>
                                                    <a class="m-1 edit_library_sub_category"
                                                       href="{{route('admin.library.category.sub-category.edit',$sub_cat->id)}}"
                                                       id="{{$sub_cat->id}}"
                                                       data-id="" title="تعديل">
                                                        <i class="fa-solid fa-user-pen"></i>
                                                    </a>
                                                    <a class="m-1 delete_library_sub_category"
                                                       href="{{route('admin.library.category.sub-category.delete',$sub_cat->id)}}"
                                                       data-id="{{$sub_cat->id}}"
                                                       id="delete_library_sub_category_{{$sub_cat->id}}"
                                                       title="حذف">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-5" data-repeater-list="sub_category">
                                    <div data-repeater-item>
                                        <div class="row d-flex align-items-end">
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="itemname"> اسم القسم الفرعي </label>
                                                    <input type="text" class="form-control" name="title"
                                                           aria-describedby="itemname"
                                                           placeholder="عنوان العنوان الفرعي "/>
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label" for="itemname">  وصف قصير  </label>
                                                    <input type="text" class="form-control" name="description"
                                                           aria-describedby="itemname"
                                                           placeholder="وصف قصير"/>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="itemname"> صورة القسم الفرعي </label>
                                                    <input type="file" class="form-control" name="image"
                                                           accept=".png,.jpg,.jpeg"
                                                           aria-describedby="itemname"
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
    <div class="modal fade text-start" id="edit-library-sub-category-modal" tabindex="-1" aria-labelledby="myModalLabel34"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل بيانات القسم الفرعي </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.library.category.sub-category.update')}}" id="edit-sub-category-form" method="post"
                      enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="sub_category_id">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" class="form-control" name="title" id="edit_sub_category_input_title"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text edit_sub_category_title_err"></span>
                        </div>
     <label>وصف قصير : </label>
                        <div class="mb-1">
                            <input type="text" class="form-control" name="description" id="edit_sub_category_input_description"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text edit_sub_category_description_err"></span>
                        </div>

                        <div class="mb-1">
                            <label>الصورة: </label>
                            <input type="file" class="form-control" name="image" accept=".png , .jpg, .jpeg"/>
                            <p class="mt-1">
                                <small class="text-muted">الصورة تقبل فقط صيغة png jpg jpeg.</small>
                            </p>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text edit_sub_category_image_err"></span>
                        </div>
                        <div class="mb-1">
                            <label>الصورة: </label>
                            <img id="sub_category_img" width="100%" height="200px">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </div>
                </form>
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
        $(document).on('click', '.delete_library_sub_category', function (e) {
            e.preventDefault();
            let actionUrl = $(this).attr('href');
            let pid = $(this).attr('data-id');
            Swal.fire({
                title: "تأكيد الحذف ؟",
                text: "هل انت متأكد من عملية الحذف !",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "نعم , حذف",
                cancelButtonText: "الغاء",
                customClass: {
                    confirmButton: "btn btn-primary confirm_delete_library_sub_category",
                    cancelButton: "btn btn-outline-danger ms-1"
                },
                buttonsStyling: !1
            });
            $('.confirm_delete_library_sub_category').on('click', function (t) {
                t.preventDefault();
                $.ajax({
                    url: actionUrl,
                    type: 'get',
                    success: function (response) {
                        $('body #delete_library_sub_category_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
                        setTimeout(() => {
                            Swal.fire({
                                icon: "success",
                                title: "تم الحذف !",
                                text: " تم الحذف  بنجاح. ",
                                confirmButtonText: 'موافق',
                                customClass: {confirmButton: "btn btn-success"}
                            })
                        }, 1000);
                    },
                    error: function () {
                        Swal.fire({
                            title: "مشكلة !",
                            text: " هناك مشكلة في النظام يرجى مراجعة مدير النظام !",
                            icon: "error",
                            confirmButtonText: "موافق",
                            customClass: {confirmButton: "btn btn-primary"},
                            buttonsStyling: !1
                        })
                    }
                });

            })

        });

        $('.edit_library_sub_category').on('click', function (e) {
            e.preventDefault();
            let btn = $(this);
            let editUrl = btn.attr('href');
            $.ajax({
                url: editUrl,
                type: 'get',
                success: function (response) {
                    $('#edit-sub-category-form #sub_category_id').val(response.item.id);
                    $('#edit-sub-category-form #edit_sub_category_input_title').val(response.item.title);
                    $('#edit-sub-category-form #edit_sub_category_input_description').val(response.item.description);
                    $('#edit-sub-category-form #sub_category_img').attr('src', response.item.image);
                    $('#edit-library-sub-category-modal').modal('show');
                },
            });
        });
        $('#edit-sub-category-form').submit(function (e) {
            e.preventDefault();
            let actionUrl = $(this).attr('action');
            let formData = getFormInputs($(this));
            $.ajax({
                url: actionUrl,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "تهانينا  !",
                        text: " تم تحديث  بنجاح. ",
                        confirmButtonText: 'موافق',
                        customClass: {confirmButton: "btn btn-success"}
                    }).then(function () {
                        location.reload();
                    });
                },
                error: function (error) {
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.edit_sub_category_' + key + '_err').text(value);
                    });
                    $('#edit-library-sub-category-modal').modal('show');

                }
            });
        })
    </script>
@endsection
