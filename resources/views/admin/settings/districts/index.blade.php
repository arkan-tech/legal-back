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
                                    <a class="dt-button btn btn-primary " id="add_new_district_btn">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة حي</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="districts_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>المدينة</th>
                                    <th>المنطقة</th>
                                    <th>المدينة</th>
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
    <div class="modal fade text-start" id="save_districts_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">حفظ بيانات المدينة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.districts.store')}}" method="post" id="save_district_form">
                    @csrf
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_save_name_error "></span>
                        </div>
                        <label> الدولة : </label>
                        <div class="mb-1">
                            <select name="country_id" id="save_country_id_select" class="form-control select2">
                                <option value="">اختر</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_save_country_id_error "></span>
                        </div>
                        <label> المنطقة : </label>
                        <div class="mb-1">
                            <select name="region_id" id="save_region_id_select" class="form-control select2">
                                @include('admin.digital_guide.includes.edit.region-select',['regions'=>[]])
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_save_region_id_error "></span>
                        </div>
                        <label> المدينة : </label>
                        <div class="mb-1">
                            <select name="city_id" id="save_city_id_select" class="form-control select2">
                                @include('admin.digital_guide.includes.edit.cities-select',['cities'=>[]])
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_save_city_id_error "></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="edit_districts_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل بيانات الحي </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.districts.update')}}" method="post" id="edit_district_form">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_edit_name_error "></span>
                        </div>
                        <label> الدولة : </label>
                        <div class="mb-1">
                            <select name="country_id" id="edit_country_id_select" class="form-control select2">
                                <option value="">اختر</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_edit_country_id_error "></span>
                        </div>
                        <label> المنطقة : </label>
                        <div class="mb-1">
                            <select name="region_id" id="edit_region_id_select" class="form-control select2">
                                @include('admin.digital_guide.includes.edit.region-select',['regions'=>$regions])
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_edit_region_id_error "></span>
                        </div>
                        <label> المدينة : </label>
                        <div class="mb-1">
                            <select name="city_id" id="edit_city_id_select" class="form-control select2">
                                @include('admin.digital_guide.includes.edit.cities-select',['cities'=>$cities])
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text district_edit_city_id_error "></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('admin/app-assets/js/datatable/settings/districts/districts_list.js?'.time())}}"></script>
    <script>
        $('#save_country_id_select').on('change', function (e) {
            e.preventDefault();
            let country_id = $(this).val();
            let actionUrl = '{{route('admin.digital-guide.get-regions-bade-country-id')}}' + '/' + country_id;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#save_region_id_select').html(response.items_html);
                }
            });
        })
        $('#save_region_id_select').on('change', function (e) {
            e.preventDefault();
            let region_id = $(this).val();
            let actionUrl = '{{route('admin.digital-guide.get-cities-bade-region-id')}}' + '/' + region_id;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#save_city_id_select').html(response.items_html);
                }
            });
        });
    </script>
@endsection
