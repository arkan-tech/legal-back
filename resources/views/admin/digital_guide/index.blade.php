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
								<h6 class="mb-0">الدليل الرقمي</h6>
                            </div>
                        </div>
                        <div class="mb-12 p-2">
                            <div class="row align-items-center">
                                <div class="col-lg-12 col-xl-12">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <label for="">حالة الحساب</label>
                                            <select class="form-control select2" name="accepted" id="accepted_select">
                                                <option value="">اختر</option>
                                                <option value="جديد" >جديد</option>
                                                <option value="مقبول" >مقبول</option>
                                                <option value="انتظار" >انتظار</option>
                                                <option value="محظور">محظور</option>
                                            </select>
                                        </div>
										<div class="col-lg-8 d-flex justify-content-end">
                                            <a class="btn btn-primary" href="{{route('admin.digital-guide.export-lawyers')}}">
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
                                    <th>الموبايل</th>
                                    <th>مقدمة الدولة</th>
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

@endsection
@section('scripts')
    <script src="{{asset('admin/app-assets/js/datatable/digital_guide/digital_guide_list.js?'.time())}}"></script>

@endsection
