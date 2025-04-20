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
							<div class="head-label d-flex gap-1">
								<h6 class="mb-0">قائمة العملاء</h6>
                            </div>
                        </div>
                        <div class="mb-12 p-2">
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-xl-12">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <label for="">حالة الحساب</label>
                                            <select class="form-control select2" name="accepted" id="client_accepted_select">
                                                <option value="">اختر</option>
                                                <option value="جديد" >جديد</option>
                                                <option value="مقبول" >مقبول</option>
                                                <option value="انتظار" >انتظار</option>
                                                <option value="محظور">محظور</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-8 d-flex justify-content-end">
                                            <a class="btn btn-primary" href="{{route('admin.clients.export-users')}}">
											Export Users
											</a>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="digital_guide_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الايميل</th>
                                    <th>الدولة</th>
                                    <th>الموبايل</th>
                                    <th>مقدمة الدولة</th>
                                    <th>الصفة</th>
                                    <th>الحالة </th>
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
    <div class="modal fade text-start" id="send_client_message_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> رد على الرسالة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="send_client_message_form" action="{{route('admin.clients.send-email')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label> عنوان الرسالة : </label>
                                <div class="mb-1">
                                    <input type="text" name="message_subject" class="form-control" required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> الرسالة : </label>
                                <div class="mb-1">
                                    <textarea id="message" rows="3" class="form-control" name="message_body" required></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >ارسال الرسالة </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('admin/app-assets/js/datatable/clients/clients_list.js?'.time())}}"></script>

@endsection
