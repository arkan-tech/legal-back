@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @if ($errors->any())

                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading"> خطأ في البيانات</h4>
                    <div class="alert-body">
                        <div class="">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            @endif

            <div class="content-body">
                <div class="row">
                    <div class="col-12">

                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.library.rules_regulations.update')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> تعديل</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> القسم الرئيسي </label>
                                            <select id="category_id"
                                                    class="form-control select2 @error('category_id')is-invalid @enderror"
                                                    name="category_id">
                                                <option value=""> اختر قسم رئيسي</option>

                                                @foreach($main_cat as $cat)
                                                    <option
                                                        {{ $cat->id == $item->category_id ? 'selected':''}} value="{{$cat->id}}"> {{$cat->title}} </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> القسم الفرعي </label>
                                            <select id="sub_category_id"
                                                    class="form-control select2 @error('sub_category_id')is-invalid @enderror"
                                                    name="sub_category_id">
                                                @include('admin.library.rules_regulations.includes.sub-cat-select')
                                            </select>
                                            @error('sub_category_id')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="name">اسم </label>
                                            <input type="text"
                                                   class="form-control @error('name')is-invalid @enderror"
                                                   name="name" value="{{$item->name}}"/>
                                            @error('name')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="release_date">تاريخ الإصدار </label>
                                            <input type="date"
                                                   class="form-control @error('release_date')is-invalid @enderror"
                                                   name="release_date" value="{{$item->release_date}}"/>
                                            @error('release_date')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="publication_date">تاريخ النشر </label>
                                            <input type="date"
                                                   class="form-control @error('publication_date')is-invalid @enderror"
                                                   name="publication_date" value="{{$item->publication_date}}"/>
                                            @error('publication_date')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="status">الحالة </label>
                                            <input type="text"
                                                   class="form-control @error('status')is-invalid @enderror"
                                                   name="status" value="{{$item->status}}"/>
                                            @error('status')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="law_name">اسم القانون </label>
                                            <input type="text"
                                                   class="form-control @error('law_name')is-invalid @enderror"
                                                   name="law_name" value="{{$item->law_name}}"/>
                                            @error('law_name')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="law_description">وصف قصير القانون </label>
                                            <input type="text"
                                                   class="form-control @error('law_description')is-invalid @enderror"
                                                   name="law_description" value="{{$item->law_description}}"/>
                                            @error('law_description')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>


                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="world_file"> الكتاب النسخة
                                                صيغة وورد</label>
                                            <input type="file"
                                                   class="form-control @error('world_file')is-invalid @enderror"
                                                   name="world_file" accept=".doc, .docx"/>
                                            @if(!is_null($item->world_file))
                                                <a href="{{$item->world_file}}"
                                                   download="world file "
                                                   target="_blank"
                                                   class="btn btn-sm btn-primary mb-75"> تنزيل و معاينة الملف
                                                </a>
                                            @endif

                                            @error('world_file')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="pdf_file"> الكتاب النسخة
                                                صيغة pdf</label>
                                            <input type="file"
                                                   class="form-control @error('pdf_file')is-invalid @enderror"
                                                   name="pdf_file" accept=".pdf"/>
                                            @if(!is_null($item->pdf_file))
                                                <iframe id=""
                                                        style="border:1px solid #666CCC"
                                                        title="PDF in an i-Frame"
                                                        src="{{$item->pdf_file}}" frameborder="1" scrolling="auto"
                                                        alt="profile image"
                                                        height="300" width="450"
                                                        class="rounded me-50">

                                                </iframe>
                                            @endif


                                            @error('pdf_file')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="about"> وصف قصير</label>
                                            <textarea name="about"
                                                      class="form-control @error('about')is-invalid @enderror"
                                                      cols="30" rows="2">{{ $item->about}}</textarea>
                                            @error('about')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row release_tools">
                                        <label class="form-label text-center mt-3"> ادوات النشر</label>

                                        <table class="table text-center " id="RulesRegulationsReleaseToolsTable">
                                            <thead>
                                            <tr>
                                                <th scope="col">الأداة</th>
                                                <th scope="col">عمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($item->ReleasTools as $tool)
                                                <tr>
                                                    <td>{{$tool->tool_name}}</td>
                                                    <td>
                                                        <a class="btn-delete-rules-regulations-release-tools m-1"
                                                           id="btn_delete_rules_regulations_release_tools_{{$tool->id}}"
                                                           href="{{route('admin.library.rules_regulations.delete.release.tool', $tool->id)}}"
                                                           data-id="{{$tool->id}}" title="حذف ">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div data-repeater-list="release_tools">
                                            <div data-repeater-item>
                                                <div class="row d-flex align-items-end">
                                                    <div class="col-md-8 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="itemname">اداة نشر </label>
                                                            <input type="text" name="tool" class="form-control"
                                                                   id="itemname" aria-describedby="itemname"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 col-12 mb-50">
                                                        <div class="mb-1">
                                                            <button class="btn btn-outline-danger text-nowrap px-1"
                                                                    data-repeater-delete type="button">
                                                                <i data-feather="x" class="me-25"></i>
                                                                <span>حذف</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary" type="button"
                                                        data-repeater-create>
                                                    <i data-feather="plus" class="me-25"></i>
                                                    <span>اضافة اداة </span>
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="text"> نـــص النظـــام</label>
                                            <textarea name="text"
                                                      class="form-control @error('text')is-invalid @enderror ck_editor"
                                                      cols="30" rows="20">{!! $item->text !!}</textarea>
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
                                <a href="{{route('admin.library.rules_regulations.index')}}" type="reset"
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
        $('#category_id').on('change', function () {
            let value = $(this).val();
            let actionUrl = '{{route('admin.library.rules_regulations.get-library-sub-cat-base-id')}}' + '/' + value;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#sub_category_id').html(response.items_html);
                }
            })
        });

        $('.release_tools').repeater({

            show: function () {
                $(this).slideDown();
                // Feather Icons
                if (feather) {
                    feather.replace({width: 14, height: 14});
                }
            },
            hide: function (deleteElement) {
                if (confirm('هل انت متأكد من حذف العنصر ؟')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });

        $(document).on('click', '.btn-delete-rules-regulations-release-tools', function (e) {
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
                    confirmButton: "btn btn-primary confirm_btn_rules_regulations_release_tools",
                    cancelButton: "btn btn-outline-danger ms-1"
                },
                buttonsStyling: !1
            });
            $('.confirm_btn_rules_regulations_release_tools').on('click', function (t) {
                t.preventDefault();
                $.ajax({
                    url: actionUrl,
                    type: 'get',
                    success: function (response) {
                        $('#RulesRegulationsReleaseToolsTable #btn_delete_rules_regulations_release_tools_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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
    </script>

@endsection


