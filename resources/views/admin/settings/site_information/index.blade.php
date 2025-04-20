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
                              action="{{route('admin.settings.site-information.update')}}"
                              method="POST" enctype="multipart/form-data">

                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> اعدادات الموقع</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                        @foreach($settings as $setting)
                                            <div class="row mt-1 mb-2">
                                            <label>{{$setting->display_name}} </label>
                                                <div class="col-lg-12 ">
                                                    <input class="form-control  @error($setting->key)is-invalid @enderror"
                                                        name="{{$setting->key}}" value="{{$setting->value}}" required/>
                                                    @error($setting->key)
                                                    <p class="invalid-feedback">{{$message}}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach




                                </div>

                                <div class="card appointment-repeater " id="appointments_options_div" data-id="0">
                                    <div class="card-body">
                                        <div class="card-header">
                                            <h4 class="card-title">المواعيد المتاحة</h4>
                                        </div>
                                        <div data-repeater-list="appointments" class="appointments_div" >
                                            <div data-repeater-item class="data-repeater-item" data-id="0">
                                                <div class="row d-flex align-items-end">
                                                    <div class="col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="itemname">التاريخ </label>
                                                            <input type="date" class="form-control" id="itemname"
                                                                   name="date" required/>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="card-header">
                                                            <h4 class="card-title">الاوقات المتاحة في اليوم </h4>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="12:00:00-01:00:00"
                                                                   id="12:00:00-01:00:00">
                                                            <label class="form-check-label" for="12:00:00-01:00:00">
                                                                12:00:00 - 01:00:00
                                                            </label>
                                                        </div>

                                                        <div class="col-lg-2 d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="01:00:00-02:00:00"
                                                                   id="01:00:00 - 02:00:00">
                                                            <label class="form-check-label" for="01:00:00 - 02:00:00">
                                                                01:00:00 - 02:00:00
                                                            </label>
                                                        </div>

                                                        <div class="col-lg-2 d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="02:00:00-03:00:00"
                                                                   id="02:00:00 - 03:00:00">
                                                            <label class="form-check-label" for="02:00:00 - 03:00:00">
                                                                02:00:00 - 03:00:00
                                                            </label>
                                                        </div>


                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="03:00:00-04:00:00"
                                                                   id="03:00:00 - 04:00:00">
                                                            <label class="form-check-label" for="03:00:00 - 04:00:00">
                                                                03:00:00 - 04:00:00
                                                            </label>
                                                        </div>


                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="04:00:00-05:00:00"
                                                                   id="04:00:00 - 05:00:00">
                                                            <label class="form-check-label" for="04:00:00 - 05:00:00">
                                                                04:00:00 - 05:00:00
                                                            </label>
                                                        </div>


                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="05:00:00-06:00:00"
                                                                   id="05:00:00 - 06:00:00">
                                                            <label class="form-check-label" for="05:00:00 - 06:00:00">
                                                                05:00:00 - 06:00:00
                                                            </label>
                                                        </div>


                                                        <div class="col-lg-2 d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="06:00:00-07:00:00"
                                                                   id="06:00:00 - 07:00:00">
                                                            <label class="form-check-label" for="06:00:00 - 07:00:00">
                                                                06:00:00 - 07:00:00
                                                            </label>
                                                        </div>

                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="07:00:00-08:00:00"
                                                                   id="07:00:00 - 08:00:00">
                                                            <label class="form-check-label" for="07:00:00 - 08:00:00">
                                                                07:00:00 - 08:00:00
                                                            </label>
                                                        </div>


                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="08:00:00-09:00:00"
                                                                   id="08:00:00 - 09:00:00">
                                                            <label class="form-check-label" for="08:00:00 - 09:00:00">
                                                                08:00:00 - 09:00:00
                                                            </label>
                                                        </div>


                                                        <div class="col-lg-2 d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="09:00:00-10:00:00"
                                                                   id="09:00:00 - 10:00:00">
                                                            <label class="form-check-label" for="09:00:00 - 10:00:00">
                                                                09:00:00 - 10:00:00
                                                            </label>
                                                        </div>

                                                        <div class="col-lg-2 d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="10:00:00-11:00:00"
                                                                   id="10:00:00 - 11:00:00">
                                                            <label class="form-check-label" for="10:00:00 - 11:00:00">
                                                                10:00:00 - 11:00:00
                                                            </label>
                                                        </div>


                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="11:00:00-12:00:00"
                                                                   id="11:00:00 - 12:00:00">
                                                            <label class="form-check-label" for="11:00:00 - 12:00:00">
                                                                11:00:00 - 12:00:00
                                                            </label>
                                                        </div>

                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="12:00:00-13:00:00"
                                                                   id="12:00:00 - 13:00:00">
                                                            <label class="form-check-label" for="12:00:00 - 13:00:00">
                                                                12:00:00 - 13:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="13:00:00-14:00:00"
                                                                   id="13:00:00 - 14:00:00">
                                                            <label class="form-check-label" for="13:00:00 - 14:00:00">
                                                                13:00:00 - 14:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="14:00:00-15:00:00"
                                                                   id="14:00:00 - 15:00:00">
                                                            <label class="form-check-label" for="14:00:00 - 15:00:00">
                                                                14:00:00 - 15:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="15:00:00-16:00:00"
                                                                   id="15:00:00 - 16:00:00">
                                                            <label class="form-check-label" for="15:00:00 - 16:00:00">
                                                                15:00:00 - 16:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="16:00:00-17:00:00"
                                                                   id="16:00:00 - 17:00:00">
                                                            <label class="form-check-label" for="16:00:00 - 17:00:00">
                                                                16:00:00 - 17:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="17:00:00-18:00:00"
                                                                   id="17:00:00 - 18:00:00">
                                                            <label class="form-check-label" for="17:00:00 - 18:00:00">
                                                                17:00:00 - 18:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="18:00:00-19:00:00"
                                                                   id="18:00:00 - 19:00:00">
                                                            <label class="form-check-label" for="18:00:00 - 19:00:00">
                                                                18:00:00 - 19:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="19:00:00-20:00:00"
                                                                   id="19:00:00 - 20:00:00">
                                                            <label class="form-check-label" for="19:00:00 - 20:00:00">
                                                                19:00:00 - 20:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="20:00:00-21:00:00"
                                                                   id="20:00:00 - 21:00:00">
                                                            <label class="form-check-label" for="20:00:00 - 21:00:00">
                                                                20:00:00 - 21:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="21:00:00-22:00:00"
                                                                   id="21:00:00 - 22:00:00">
                                                            <label class="form-check-label" for="21:00:00 - 22:00:00">
                                                                21:00:00 - 22:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="22:00:00-23:00:00"
                                                                   id="22:00:00 - 23:00:00">
                                                            <label class="form-check-label" for="22:00:00 - 23:00:00">
                                                                22:00:00 - 23:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">

                                                            <input class="form-check-input" type="checkbox"
                                                                   name="time" value="23:00:00-24:00:00"
                                                                   id="23:00:00 - 24:00:00">
                                                            <label class="form-check-label" for="23:00:00 - 24:00:00">
                                                                23:00:00 - 24:00:00
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-2 d-flex">
                                                        </div>
                                                        <div class="col-12 mb-50 mt-3">
                                                            <div class="mb-1">
                                                                <button class="btn btn-outline-danger text-nowrap px-1"
                                                                        data-repeater-delete type="button">
                                                                    <i data-feather="x" class="me-25"></i>
                                                                    <span>حذف</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary" type="button"
                                                        data-repeater-create>
                                                    <i data-feather="plus" class="me-25"></i>
                                                    <span>تاريخ جديد </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                        </button>
                                    </div>
                                </div>
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
