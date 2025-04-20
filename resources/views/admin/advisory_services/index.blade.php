@extends('admin.layouts.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading"> خطأ في البيانات</h4>
                    <div class="alert-body">
                        <div class="">
                            <ul>
                                <li> {{Session::get('error')}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <div class="content-body">
                <!-- equipments list start -->
                <section class="app-equipment-list">
                    <div class="card">
                        <div class="card-header border-bottom p-1">
                            <div class="head-label d-flex gap-1">
                                <h6 class="mb-0">نافذة الأستشارات</h6>
								<h6>/</h6>
                                <h6 class="mb-0">وسائل الأستشارات</h6>
                            </div>
                            <div class="dt-action-buttons text-end">
                                <div class="dt-buttons d-inline-flex">
                                    <a href="{{route('admin.advisory_services.create')}}" class="dt-button btn btn-primary">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة  خدمة استشارية</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="advisory_services_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>القسم</th>
                                    <th>السعر الأدنى</th>
                                    <th>السعر الأعلى</th>
                                    <th>سعر يمتاز</th>
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
    <div class="modal fade text-start" id="save_advisory_services_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">حفظ خدمة استشارية </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.advisory_services.store')}}" method="post"
                      id="save_advisory_services_form">
                    @csrf
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="save_advisory_services_name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_save_name_error "></span>
                        </div>
                        <label>السعر : </label>
                        <div class="mb-1">
                            <input type="number" id="save_advisory_services_price" name="price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_save_price_error "></span>
                        </div>
                        <label>الهاتف : </label>
                        <div class="mb-1">
                            <input type="number" id="save_advisory_services_phone" name="phone" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_save_phone_error "></span>
                        </div>
                        <label>صورة تعبيرية : </label>
                        <div class="mb-1">
                            <input type="file" id="save_advisory_services_image" accept=".png , .jpg , .jpeg"
                                   name="image" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_save_image_error "></span>
                        </div>
                        <label>وصف قصير : </label>
                        <div class="mb-1">
                            <textarea rows="3" id="save_advisory_services_description" name="description"
                                      class="form-control"></textarea>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_save_description_error "></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="edit_advisory_services_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل خدمة استشارية </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.advisory_services.update')}}" method="post"
                      id="edit_advisory_services_form">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <label>الاسم : </label>
                        <div class="mb-1">
                            <input type="text" id="edit_advisory_services_name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_update_name_error "></span>
                        </div>
                        <label>السعر : </label>
                        <div class="mb-1">
                            <input type="number" id="edit_advisory_services_price" name="price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_update_price_error "></span>
                        </div>
                        <label>الهاتف : </label>
                        <div class="mb-1">
                            <input type="number" id="edit_advisory_services_phone" name="phone" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_update_phone_error "></span>
                        </div>
                        <label>صورة تعبيرية : </label>
                        <div class="mb-1">
                            <input type="file" id="edit_advisory_services_image" accept=".png , .jpg , .jpeg"
                                   name="image" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_update_image_error "></span>
                        </div>
                        <div class="mb-1">
                            <img id="edit_advisory_services_show_image" width="70px" height="70px">
                        </div>
                        <label>وصف قصير : </label>
                        <div class="mb-1">
                            <textarea rows="3" id="edit_advisory_services_description" name="description"
                                      class="form-control"></textarea>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text advisory_services_update_description_error "></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="show_advisory_services_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">عرض خدمة استشارية </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>الاسم : </label>
                    <div class="mb-1">
                        <span id="show_title" class="form-control"/>
                    </div>
                    <label>السعر : </label>
                    <div class="mb-1">
                        <span id="show_price" class="form-control"/>
                    </div>
                    <label>الهاتف : </label>
                    <div class="mb-1">
                        <span id="show_phone" class="form-control"/>
                    </div>
                    <label>وصف قصير : </label>
                    <div class="mb-1">
                        <textarea rows="3" id="show_description" class="form-control"> </textarea>
                    </div>
                    <label> صورة تعبيرية : </label>
                    <div class="mb-1">
                        <img id="show_image" width="70px" height="70px">
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
        src="{{asset('admin/app-assets/js/datatable/advisory_services/advisory_services_list.js?'.time())}}"></script>

@endsection
