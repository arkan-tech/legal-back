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
                            <div class="dt-action-buttons ">
                                <div class="dt-buttons d-inline-flex">
                                    <a class="dt-button btn btn-primary add_new_services_btn" href="{{route('admin.services.create')}}" >
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة خدمة</span>
                                    </a>
                                </div>
                                <div class="dt-buttons d-inline-flex">
                                    <a class="dt-button btn btn-primary "  data-bs-toggle="modal" data-bs-target="#save_request_levels_modal">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة مستوى</span>
                                    </a>
                                </div>
                                <div class="dt-buttons d-inline-flex">
                                    <a class="dt-button btn btn-primary"
                                       data-bs-toggle="modal" data-bs-target="#save_services_categories_modal">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-plus me-50 font-small-4">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>اضافة قسم رئيسي</span>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="services_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>القسم الرئيسي</th>
                                    <th>مسمى الخدمة</th>
                                    <th>السعر الادنى</th>
                                    <th>السعر الاقصى</th>
                                    <th>  سعر يمتاز الاصلي</th>
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

    <div class="modal fade text-start" id="save_request_levels_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">حفظ بيانات المستوى  </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.request_levels.store')}}" method="post" id="save_request_levels_form">
                    @csrf
                    <div class="modal-body">
                        <label>العنوان : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text request_levels_save_name_error "></span>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade text-start" id="save_services_categories_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">حفظ بيانات القسم الرئيسي </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.services.categories.store')}}" method="post" id="save_categories_categories_form">
                    @csrf
                    <div class="modal-body">
                        <label>العنوان : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_categories_save_name_error "></span>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade text-start" id="save_services_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">حفظ بيانات الخدمة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.services.store')}}" method="post" id="save_services_form">
                    @csrf
                    <div class="modal-body">


                        <label>العنوان : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_name_error "></span>
                        </div>

                        <label> القسم الرئيسي: </label>
                        <div class="mb-1">
                            <select name="category_id"
                                    id="category_id"
                                    class="form-control select2">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_category_id_error "></span>
                        </div>


                        <label> مستوى الطلب : </label>
                        <div class="mb-1">
                            <select name="request_level_id"
                                    id="request_level_id"
                                    class="form-control select2">
                                @foreach($request_levels as $request_level)
                                    <option value="{{$request_level->id}}">{{$request_level->name}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_request_level_id_error "></span>
                        </div>

                        <label>تعريف عن الخدمة : </label>
                        <div class="mb-1">
                            <textarea id="intro" name="intro" rows="3" class="form-control"> </textarea>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_intro_error "></span>
                        </div>

                        <label>وصف عن الخدمة : </label>
                        <div class="mb-1">
                            <textarea id="details" name="details" rows="3" class="form-control"> </textarea>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_details_error "></span>
                        </div>


                        <label> التخصص : </label>
                        <div class="mb-1">
                            <select name="section_id[]" multiple="multiple"
                                    id="sections"
                                    class="form-control select2">
                                @foreach($sections as $section)
                                    <option value="{{$section->id}}">{{$section->title}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_section_id_error "></span>
                        </div>
                        <label>السعر الادني : </label>
                        <div class="mb-1">
                            <input type="number" id="min_price" name="min_price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_min_price_error "></span>
                        </div>

                        <label>السعر الاقصى : </label>
                        <div class="mb-1">
                            <input type="number" id="max_price" name="max_price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_max_price_error "></span>
                        </div>
                        <label>سعر يمتاز : </label>
                        <div class="mb-1">
                            <input type="number" id="ymtaz_price" name="ymtaz_price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_ymtaz_price_error "></span>
                        </div>
                        <label> الصورة : </label>
                        <div class="mb-1">
                            <input type="file" id="image" name="image" class="form-control" accept=".png,.jpg ,.jpeg"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_save_max_image_error "></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="edit_services_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل بيانات المدينة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.services.update')}}" method="post" id="edit_services_form">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <label>العنوان : </label>
                        <div class="mb-1">
                            <input type="text" id="name" name="name" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_name_error "></span>
                        </div>

                        <label> القسم الرئيسي: </label>
                        <div class="mb-1">
                            <select name="category_id"
                                    id="update_category_id"
                                    class="form-control select2">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_category_id_error "></span>
                        </div>

                        <label> مستوى الطلب : </label>
                        <div class="mb-1">
                            <select name="request_level_id"
                                    id="request_level_id"
                                    class="form-control select2">
                                @foreach($request_levels as $request_level)
                                    <option value="{{$request_level->id}}">{{$request_level->name}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_request_level_id_error "></span>
                        </div>

                        <label>تعريف عن الخدمة : </label>
                        <div class="mb-1">
                            <textarea id="intro" name="intro" rows="3" class="form-control"> </textarea>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_intro_error "></span>
                        </div>

                        <label>وصف عن الخدمة : </label>
                        <div class="mb-1">
                            <textarea id="details" name="details" rows="3" class="form-control"> </textarea>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_details_error "></span>
                        </div>

                        <label> التخصص : </label>
                        <div class="mb-1">
                            <select name="section_id[]" multiple="multiple"
                                    id="sections"
                                    class="form-control   select2">
                                @foreach($sections as $section)
                                    <option value="{{$section->id}}">{{$section->title}}</option>
                                @endforeach
                            </select>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_section_id_error "></span>
                        </div>
                        <label>السعر الادني : </label>
                        <div class="mb-1">
                            <input type="number" id="min_price" name="min_price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_min_price_error "></span>
                        </div>

                        <label>السعر الاقصى : </label>
                        <div class="mb-1">
                            <input type="number" id="max_price" name="max_price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_max_price_error "></span>
                        </div>
                        <label> سعر يمتاز : </label>
                        <div class="mb-1">
                            <input type="number" id="ymtaz_price" name="ymtaz_price" class="form-control"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_ymtaz_price_error "></span>
                        </div>
                        <label> الصورة : </label>
                        <div class="mb-1">
                            <input type="file" id="image" name="image" class="form-control" accept=".png,.jpg ,.jpeg"/>
                            <span style="display: block;text-align: right;"
                                  class="text-danger error-text services_update_max_image_error "></span>
                        </div>

                        <label> الصورة : </label>
                        <div class="mb-1">
                            <img id="image" width="200" height="200"/>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
                <script src="{{asset('admin/app-assets/js/datatable/services/services_list.js?'.time())}}"></script>
    <script>



    </script>
@endsection
