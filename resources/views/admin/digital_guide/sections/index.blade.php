@extends('admin.layouts.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            @include('admin.layouts.alerts.success')
            <div class="content-body">
                <!-- equipments list start -->
                <section class="app-equipment-list">
                    <div class="card">
                        <div class="card-header border-bottom p-1">
                            <div class="head-label">
                                <h6 class="mb-0"></h6>
                            </div>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <a class="dt-button btn btn-primary add_new_section_btn"
                                       data-bs-toggle="modal" data-bs-target="#save_section_modal">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة مهنة</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="section_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>تحتاج ترخيص</th>
                                    <th>العمليات</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- equipments list ends -->

            </div>
        </div>
    </div>
    <div class="modal fade text-start" id="save_section_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">حفظ بيانات المدينة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.digital-guide.sections.store')}}" method="post" id="save_section_form">
                    @csrf
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="title" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text section_save_title_error "></span>
                        </div>

                        <label> تحتاج ترخيص : </label>
                        <div class="mb-1">
                            <select class="form-control" name="need_license" id="need_license">
                                <option value="1">تحتاج ترخيص</option>
                                <option value="0">لا تحتاج ترخيص</option>
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text section_save_need_license_error "></span>
                        </div>
                        <label> الصورة : </label>
                        <div class="mb-1">
                            <input type="file" name="image" class="form-control" accept=".png , .jpg ,.jpeg">
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text section_save_image_error "></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="edit_section_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل بيانات المدينة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.digital-guide.sections.update')}}" method="post" id="edit_section_form">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="title" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text section_update_title_error "></span>
                        </div>
                        <label> تحتاج ترخيص : </label>
                        <div class="mb-1">
                            <select class="form-control" name="need_license" id="need_license">
                                <option value="1">تحتاج ترخيص</option>
                                <option value="0">لا تحتاج ترخيص</option>
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text section_update_need_license_error "></span>
                        </div>
                        <br>
                        <img id="section_update_image" width="30%" height="30%">
                        <br>
                        <label> الصورة : </label>
                        <div class="mb-1">
                            <input type="file" name="image" class="form-control">
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text section_update_image_error "></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('admin/app-assets/js/datatable/digital_guide/sections/sections_list.js?'.time())}}"></script>
@endsection
