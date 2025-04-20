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
								<h6 class="mb-0">نافذة الأستشارات</h6>
								<h6>/</h6>
                                <h6 class="mb-0">باقات الأستشارات</h6>
                            </div>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <a class="dt-button btn btn-primary" href="{{route('admin.advisory_services.payment_categories.create')}}">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة قسم</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="advisory_services_payment_categories_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
									<th>الفئة الرئيسية</th>
                                    <th>الاسم</th>
                                    <th>حالة الدفع</th>
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
    <script
        src="{{asset('admin/app-assets/js/datatable/advisory_services/payment_categories/advisory_services_payment_categories_list.js?'.time())}}"></script>

@endsection
