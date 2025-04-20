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

                                </div>
                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="complaint_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>العميل</th>
                                    <th>مقدم الخدمة</th>
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

    <div class="modal fade text-start" id="show_complaint_modal" tabindex="-1" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">عرض الشكوى </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-header ">
                        <h4>معلومات العميل</h4>
                    </div>
                    <div class=" card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>اسم : </label>
                                <div class="mb-1">
                                    <span id="client_name" class="form-control"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>ايميل : </label>
                                <div class="mb-1">
                                    <span id="client_email" class="form-control"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>الجوال : </label>
                                <div class="mb-1">
                                    <span id="client_mobile" class="form-control"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-header ">
                        <h4>معلومات مقدم الخدمة</h4>
                    </div>
                    <div class=" card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>اسم : </label>
                                <div class="mb-1">
                                    <span id="lawyer_name" class="form-control"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>ايميل : </label>
                                <div class="mb-1">
                                    <span id="lawyer_email" class="form-control"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>الجوال : </label>
                                <div class="mb-1">
                                    <span id="lawyer_mobile" class="form-control"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-header ">
                        <h4>معلومات الشكوى</h4>
                    </div>
                    <div class=" card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label>محتوى الشكوى : </label>
                                <div class="mb-1">
                                    <textarea disabled rows="7" id="complaint_body" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal">اغلاق</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script
        src="{{asset('admin/app-assets/js/datatable/complaint/complaint_list.js?'.time())}}"></script>

@endsection
