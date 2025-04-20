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
                <section class="">
                    <div class="card">
                        <div class="mb-12 p-2">
                            <div class="row align-items-center">

                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="delete_account_request_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>العميل</th>
                                    <th> سبب الحذف</th>
                                    <th> مقترح التطوير</th>
                                    <th> حالة الطلب</th>
                                    <th> تاريخ الطلب</th>
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
    <div class="modal fade text-start" id="show_client_delete_account_request_modal" tabindex="-1"
         aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> عرض الطلب </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label> العميل : </label>
                            <div class="mb-1">
                                <span id="client_name" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label> الجوال : </label>
                            <div class="mb-1">
                                <span id="client_phone" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label> الايميل : </label>
                            <div class="mb-1">
                                <span id="client_email" class="form-control"/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label> سبب الحذف  : </label>
                            <div class="mb-1">
                                <textarea id="delete_reason" rows="5" class="form-control" disabled></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>  مقترح التطوير  : </label>
                            <div class="mb-1">
                                <textarea id="development_proposal" rows="5" class="form-control" disabled></textarea>
                            </div>
                        </div>

                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal">اغلاق</button>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="replay_client_service_request_modal" tabindex="-1"
         aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> رد على الاستشارة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="replay_client_service_request_form"
                      action="{{route('admin.clients.service-request.SendFinalReplay')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label> العميل : </label>
                                <div class="mb-1">
                                    <span id="client_name" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label> الجوال : </label>
                                <div class="mb-1">
                                    <span id="client_phone" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label> الايميل : </label>
                                <div class="mb-1">
                                    <span id="client_email" class="form-control"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label> الخدمة : </label>
                                <div class="mb-1">
                                    <span id="service" class="form-control"/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> مستوى الطلب : </label>
                                <div class="mb-1">
                                    <span id="priority" class="form-control"/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> وصف الطلب : </label>
                                <div class="mb-1">
                                    <textarea id="description" rows="5" class="form-control" disabled></textarea>
                                </div>
                            </div>

                        </div>

                        <hr>



                        <div class="row">
                            <div class="col-lg-6">
                                <a target="_blank" class="btn btn-primary download_service_request_file">
                                    مرفقات العميل
                                </a>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> الرد : </label>
                                <div class="mb-1">
                                    <textarea name="replay_message" rows="3" class="form-control" required></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> ملف : </label>
                                <div class="mb-1">
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary confirm_replay_service_request_btn">ارسال الرد
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script
        src="{{asset('admin/app-assets/js/datatable/clients/delete-accounts-requests/delete_accounts_requests_list.js?'.time())}}"></script>

@endsection
