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
                              action="{{route('admin.advisory_services.update')}}"
                              method="POST" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> اضافة خدمة استشارية</h4>
                                </div>
                                <div class="card-body mt-2">
                                    <label>الاسم : </label>
                                    <div class="mb-1">
                                        <input type="text" name="title"
                                               class="form-control @error('title')is-invalid @enderror"
                                               value="{{$item->title}}"/>
                                        @error('title')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <label>قسم الاستشارات : </label>
                                    <div class="mb-1">
                                        <select name="payment_category_id"
                                                class="form-control select2 @error('payment_category_id')is-invalid @enderror"
                                                id="payment_category_select">
                                            <option value="">-- اختر --</option>
                                            @foreach($payment_methods as $payment_method)
                                                <option
                                                    value="{{$payment_method->id}}" {{$payment_method->id == $item->payment_category_id ?'selected':''}}>{{$payment_method->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('payment_category_id')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-1" id="min_price_div">
                                        <label>السعر الادنى :</label>
                                        <input value="{{$item->min_price}}" type="number" name="min_price" class="form-control  @error('min_price')is-invalid @enderror" value="{{old('min_price')}}"/>
                                        @error('min_price')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-1" id="max_price_div">
                                        <label>العر الاعلى : </label>
                                        <input value="{{$item->max_price}}" type="number"  name="max_price" class="form-control  @error('max_price')is-invalid @enderror" value="{{old('max_price')}}"/>
                                        @error('max_price')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
									<div class="mb-1" id="ymtaz_price_div">
                                        <label>سعر يمتاز : </label>
                                        <input value="{{$item->ymtaz_price}}" type="number"  name="ymtaz_price" class="form-control  @error('ymtaz_price')is-invalid @enderror" value="{{old('ymtaz_price')}}"/>
                                        @error('ymtaz_price')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                    
                                    <label>صورة تعبيرية : </label>
                                    <div class="mb-1">
                                        <input type="file"
                                               accept=".png , .jpg , .jpeg"
                                               name="image" class="form-control @error('image')is-invalid @enderror"/>
                                        @error('image')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <label>وصف قصير : </label>
                                    <div class="mb-1">
                                       <textarea rows="3" name="description"
                                                 class="form-control @error('description')is-invalid @enderror">{{$item->description}}</textarea>
                                        @error('description')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <label> تنبيهات وتعليمات : </label>
                                    <div class="mb-1">
                                       <textarea rows="3" name="instructions"
                                                 class="form-control ck_editor @error('instructions')is-invalid @enderror">{!! $item->instructions !!}</textarea>
                                        @error('instructions')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch mb-1">
                                        <label class="form-check-label" for="need_appointment_checkbox">هل تحتاج الى
                                            موعد ؟</label>
                                        <input class="form-check-input" type="checkbox" name="need_appointment"
                                               {{$item->need_appointment ==1?'checked':''}}
                                               id="need_appointment_checkbox">
                                    </div>
									<label> الأسعار حسب مستويات الطلب : </label>
									<div class="mb-1 repeater-level-price">
										<div data-repeater-list="levels" class=" form-group mt-3" >
											@foreach ($request_levels as $request_level)
											<div data-repeater-item >
												<div class="row d-flex align-items-end">
													<div class=" col-md-5 col-12">
														<div class="mb-1">
															<label>المستوى</label>
															<select name="level_id" selected="{{$request_level->pivot->client_reservation_id}}" required
																	class="form-control select2">	
																	<option
																		value="{{ $request_level->client_reservation_id }}"> {{$request_level->title}}  
																	</option>
															</select>
														</div>
													</div>
													<div class="col-md-3 col-12 ">
														<div class="mb-1">
															<label>السعر</label>
															<input type="number" name="price" required
															placeholder="السعر"
															class="form-control "
															maxlength="5"
															pattern="[0-9]"
															value="{{$request_level->pivot->price}}"
															oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
														</div>
													</div>
												</div>
												<hr/>
											</div>
											@endforeach 
										</div>
									</div>
                                </div>
                            </div>

                            <div class="card d-none appointment-repeater " id="appointments_options_div">
                                <div class="card-body">
                                    <div class="card-header">
                                        <h4 class="card-title">المواعيد المتاحة</h4>
                                    </div>
                                    <div data-repeater-list="appointments" class="appointments_div">
                                        <div data-repeater-item class="data-repeater-item">
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


                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
                                <a href="{{route('admin.advisory_services.index')}}" type="reset"
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
        document.addEventListener('DOMContentLoaded', function () {


            var need_appointment = '{{$item->need_appointment}}'
            let AppointmentsOptionsDiv1 = $('#appointments_options_div');
            let checkDNone1 = AppointmentsOptionsDiv1.hasClass('d-none');
            if (need_appointment == 0) {
                AppointmentsOptionsDiv1.addClass('d-none');
            } else {
                AppointmentsOptionsDiv1.removeClass('d-none');
            }



                let payment_category_id = '{{$item->payment_category_id}}';
                let actionUrl = '{{route('admin.advisory_services.get-data')}}' + '/' + payment_category_id;
                let price_div = $('#price_div');
                $.get(actionUrl, function (response) {
                    if (response.status) {
                        let payment_method = response.item.payment_method;
                        if (payment_method == 2){
                            if (price_div.hasClass('d-none')){
                                price_div.removeClass('d-none');
                            }
                        }else {
                            if (price_div.hasClass('d-none') == false){
                                price_div.addClass('d-none');
                            }
                        }
                    }
                });


        });


        $('#need_appointment_checkbox').on('change', function () {
            var checkBox = $(this).attr('checked');
            let AppointmentsOptionsDiv = $('#appointments_options_div');
            let checkDNone = AppointmentsOptionsDiv.hasClass('d-none');
            if (checkDNone == false) {
                AppointmentsOptionsDiv.addClass('d-none');
            } else {
                AppointmentsOptionsDiv.removeClass('d-none');
            }
        });


        $('#payment_category_select').on('change', function () {

            let value = $(this).val();
            let actionUrl = '{{route('admin.advisory_services.get-data')}}' + '/' + value;
            let price_div = $('#price_div');
            $.get(actionUrl, function (response) {
                if (response.status) {
                    let payment_method = response.item.payment_method;
                    if (payment_method == 2){
                        if (price_div.hasClass('d-none')){
                            price_div.removeClass('d-none');
                        }
                    }else {
                        if (price_div.hasClass('d-none') == false){
                            price_div.addClass('d-none');
                        }
                    }
                }
            });
        });
    </script>
@endsection
