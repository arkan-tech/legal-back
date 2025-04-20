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
								<div class="head-label d-flex gap-1">
									<h6 class="mb-0">وارد طلبات الأستشارات</h6>
									<h6>/</h6>
									<h6 class="mb-0">طلبات استشارات العملاء</h6>
								</div>
                            </div>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="advisory_services_reservations_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>العميل </th>
                                    <th>نوع الاستشارة</th>
                                    <th>تصنيف الخدمة</th>
                                    <th>درجة الاهمية</th>
                                    <th>السعر </th>
                                    <th>حالة الدفع </th>
                                    <th>حالة الاستشارة</th>
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
	<div class="modal fade text-start" id="replay_client_advisory_reservations_modal" tabindex="-1"
         aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">رد على الاستشارة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.client_advisory_services_reservations.replay')}}" method="post"
                      id="replay_client_advisory_reservations_form">
                    @csrf
                    <input type="hidden" name="client_reservation_id" id="id">
                    <input type="hidden" name="client_id" id="client_id">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33"> معلومات العميل </h4>
                        </div>

                        <div class="row mt-2">
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
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33"> معلومات الاستشارة</h4>
                        </div>

                        <label>  الاستشارة : </label>
                        <div class="mb-1">
                            <textarea id="message_item" class="form-control" rows="5" disabled></textarea>
                        </div>
                        <label> رسالة الرد : </label>
                        <div class="mb-1">
                            <textarea name="message" class="form-control" rows="5"></textarea>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text client_advisory_reservations_replay_message_error "></span>
                        </div>
                        <label> مرفقات : </label>
                        <div class="mb-1">
                            <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg ,.png ,.pdf">
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text client_advisory_reservations_replay_attachment_error "></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">ارسال الرد</button>
                        <a class="btn btn-primary download_file" >
                            تنزيل المرفقات
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script
        src="{{asset('admin/app-assets/js/datatable/advisory_services/reservations/advisory_services_reservations_list.js?'.time())}}"></script>

@endsection
