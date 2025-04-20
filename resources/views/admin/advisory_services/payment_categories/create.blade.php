@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
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
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.advisory_services.payment_categories.store')}}"
                              method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> اضافة قسم</h4>
                                </div>
                                <div class="card-body mt-2">
                                    <label>الاسم : </label>
                                    <div class="mb-1">
                                        <input type="text" name="name"
                                               class="form-control @error('name')is-invalid @enderror"
                                               value="{{old('name')}}" required/>
                                        @error('name')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>

									<label>فئات الاستشارات : </label>
                                    <div class="mb-1">
                                        <select name="advisory_services_base_id" required class="form-control select2 @error('advisory_services_base_id')is-invalid @enderror" id="payment_category_select">
                                            <option value="">-- اختر -- </option>
                                            @foreach($advisory_services_base as $advisory_service_base)
                                                <option value="{{$advisory_service_base->id}}">{{$advisory_service_base->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('advisory_services_base_id')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <label>طريقة الدفع : </label>
                                    <div class="mb-1">
                                        <select name="payment_method" class="form-control select2" id="payment_method">
                                            <option value="">-- اختر --</option>
                                            <option value="1"> مجانية</option>
                                            <option value="2"> مدفوعة</option>
                                            <option value="3"> متخصصة</option>
                                        </select>
                                        @error('title')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>


                                    <div class="mb-1 d-none" id="count_div">
                                        <label> عدد الاستشارات : </label>
                                        <input type="number" name="count" min="0"
                                               class="form-control @error('count')is-invalid @enderror"
                                               value="{{old('count')}}"/>
                                        @error('count')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>


                                    <div class="mb-1 d-none" id="period_div">
                                        <label> المدة (عدد الايام): </label>
                                        <input type="number" name="period"  min="0"
                                               class="form-control @error('period')is-invalid @enderror"
                                               value="{{old('period')}}"/>
                                        @error('period')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
                                <a href="{{route('admin.advisory_services.payment_categories.index')}}"
                                   class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </a>
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

    <script>
        $('#payment_method').on('change', function () {
            var value = $(this).val();
            let period_div = $('#period_div');
            let count_div = $('#count_div');
            let check_period_div = period_div.hasClass('d-none');
            let check_count_div = count_div.hasClass('d-none');
            if (value == 3) {
                if (check_period_div) {
                    period_div.removeClass('d-none');
                } else {
                    period_div.addClass('d-none');

                }
                if (check_count_div) {
                    count_div.removeClass('d-none');
                } else {
                    count_div.addClass('d-none');
                }
            } else {

                if (check_period_div == false) {
                    period_div.addClass('d-none');
                }
                if (check_count_div== false) {
                    count_div.addClass('d-none');
                }
            }

        });

    </script>
@endsection
