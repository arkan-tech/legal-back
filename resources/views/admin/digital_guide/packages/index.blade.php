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
                                    <a href="{{route('admin.digital-guide.packages.create')}}" class="dt-button btn btn-primary">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة باقة</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="packages_list_table">
                                <thead class="table-light ">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>العنوان</th>
                                    <th>السعر</th>
                                    <th>الفترة</th>
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
    <script src="{{asset('admin/app-assets/js/datatable/packages/packages_list.js?'.time())}}"></script>

@endsection
