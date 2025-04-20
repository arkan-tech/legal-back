@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.clients.delete-accounts-requests.update')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> معلومات العميل</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <input type="hidden" name="id" value="{{$request->id}}">

                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الاسم </label>
                                            <span class="form-control">{{$request->client->myname}}</span>

                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">رقم الجوال</label>
                                            <span class="form-control">{{$request->client->mobil}}</span>

                                        </div>

                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountEmail"> النوع</label>
                                            <select
                                                class="form-control @error('type') is-invalid @enderror select2"
                                                name="type" id="type_select" disabled readonly="">
                                                <option {{$request->client->type =='1' ?'selected' :''}}  value="1">
                                                    فرد
                                                </option>
                                                <option {{$request->client->type =='2' ?'selected' :''}}  value="2">
                                                    مؤسسة
                                                </option>
                                                <option {{$request->client->type =='3' ?'selected' :''}}  value="3">
                                                    شركة
                                                </option>
                                                <option {{$request->client->type =='4' ?'selected' :''}} value="4">جهة
                                                    حكومية
                                                </option>
                                                <option {{$request->client->type =='5' ?'selected' :''}}  value="5">
                                                    هيئة
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">معلومات الطلب</h4>
                                </div>

                                <div class="card-body py-2 my-25 ">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label> سبب الحذف : </label>
                                            <div class="mb-1">
                                                <textarea id="delete_reason" rows="5" class="form-control"
                                                          disabled>{{$request->delete_reason}}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label> مقترح التطوير : </label>
                                            <div class="mb-1">
                                                <textarea id="development_proposal" rows="5" class="form-control"
                                                          disabled>{{$request->development_proposal}}</textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="form-label" for="accountEmail"> حالة الطلب</label>
                                            <select class="form-control @error('status') is-invalid @enderror select2"
                                                name="status" id="status">
                                                <option {{$request->status =='0' ?'selected' :''}}  value="0">قيد
                                                    الدراسة
                                                </option>
                                                <option {{$request->status =='1' ?'selected' :''}}  value="1">مقبول
                                                </option>
                                                <option {{$request->status =='2' ?'selected' :''}}  value="2">مرفوض
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </button>
                            </div>

                        </form>
                        <!--/ form -->


                    </div>

                </div>


            </div>
        </div>
    </div>

    <!-- END: Content-->
@endsection
@section('scripts')


@endsection
