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
                                    <a class="dt-button btn btn-primary add_new_city_btn"
                                       data-bs-toggle="modal" data-bs-target="#save_client_reservations_types_modal">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة نوع حجز</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="client_reservations_types_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
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
    <div class="modal fade text-start" id="save_client_reservations_types_modal" tabindex="-1"
         aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">حفظ  نوع حجز </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.client_reservations_types.store')}}" method="post"
                      id="save_client_reservations_types_form">
                    @csrf
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="save_client_reservations_types_name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text client_reservations_types_save_name_error "></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="edit_client_reservations_types_modal" tabindex="-1"
         aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل حجز </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.client_reservations_types.update')}}" method="post"
                      id="edit_client_reservations_types_form">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="edit_client_reservations_types_name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text client_reservations_types_update_name_error "></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="show_client_reservations_types_modal" tabindex="-1"
         aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">عرض نوع حجز </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>الاسم : </label>
                    <div class="mb-1">
                        <span id="show_title" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script
        src="{{asset('admin/app-assets/js/datatable/client_reservations/types/client_reservations_types_list.js?'.time())}}"></script>

@endsection
