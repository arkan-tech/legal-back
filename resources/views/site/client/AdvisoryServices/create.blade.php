@extends('site.layouts.main')
@section('title','طلب استشارة')
@section('content')
    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">

                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <h2> الملف الشخصى </h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->
                    <div class="styled-form register-form">

                        <div class="row">

                            @include('site.client.client_right_menu')

                            <div class="col-lg-10 col-md-12 col-sm-12">

                                <div class="inbox-head">
                                    <h3> طلب استشارة جديد </h3>
                                </div>

                                <div class="styled-form register-form" style="margin-top: 25px;">
                                    <form action="{{ route('site.client.advisory-services.store') }}"
                                          id="make-advisory-services-request-form" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" value="{{auth()->guard('client')->user()->id}}"
                                               name="client_id">
                                        <input type="hidden" value="{{$lawyer_id}}" name="lawyer_id">

                                        <div class="form-group">
                                            <label for="">نوع الاستشارة</label>
                                            <select id="advisory_services" class="form-control select2"
                                                    name="advisory_services_id" style="height: 50px">
                                                @foreach($AdvisoryServices as $item)
                                                    <option value="{{$item->id}}"> {{$item->title}}  </option>
                                                @endforeach
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_advisory_services_advisory_services_id_err"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="">نوع الخدمة</label>
                                            <select id="type" class="form-control select2"
                                                    name="type" style="height: 50px">
                                                @foreach($AdvisoryServicesTypes as $item)
                                                    <option value="{{$item->id}}"> {{$item->title}}  </option>
                                                @endforeach
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_advisory_services_advisory_services_id_err"></span>
                                        </div>


{{--                                        <div class="form-group">--}}
{{--                                            <label for="">نوع الخدمة</label>--}}
{{--                                            <select id="type" class="form-control select2" name="type"--}}
{{--                                                    style="height: 50px">--}}
{{--                                                @foreach($services as $service)--}}
{{--                                                    <option--}}
{{--                                                        value="{{$service->service->id}}"> {{$service->service->title}}  </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                            <span style="display: block;text-align: right;"--}}
{{--                                                  class="text-danger error-text save_client_advisory_services_type_err"></span>--}}
{{--                                        </div>--}}

                                        <div class="form-group">
                                            <label for=""> درجة الاهمية</label>
                                            <select id="importance" class="form-control select2" name="priority"
                                                    style="height: 50px">
                                                @foreach($importance as $item)
                                                    <option value="{{$item->id}}"> {{$item->title}}  </option>
                                                @endforeach
                                            </select>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_advisory_services_priority_err"></span>
                                        </div>

                                        <div class="form-group">
                                            <textarea cols="6" style="height: 150px" rows="6" class="form-control"
                                                      type="text" id="description" name="description"
                                                      placeholder="محتوى الطلب"></textarea>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_advisory_services_description_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">المرفقات</label>
                                            <input type="file" name="file" class="form-control" id="file"
                                                   accept=".png,.jpg,.jpeg">
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_advisory_services_file_err"></span>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <h3>ايام و أوقات العمل</h3>

                                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                                @foreach($lawyer_dates as $date)

                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">

                                                            <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#panelsStayOpen-collapseOne_{{$date->id}}"
                                                                    aria-expanded="true"
                                                                    aria-controls="panelsStayOpen-collapseOne_{{$date->id}}">
                                                                {{$date->day_name}}
                                                            </button>
                                                        </h2>
                                                        <div id="panelsStayOpen-collapseOne_{{$date->id}}"
                                                             class="accordion-collapse collapse show">
                                                            <div class="accordion-body">

                                                                <div class="row">
                                                                    @foreach($date->times as $time)
                                                                        <div class="col-lg-3">
                                                                            <input class="" type="radio"
                                                                                   name="time_id" value="{{$time->id}}"
                                                                                   id="{{$time->id.'_'.$time->time_from.'-'.$time->time_to}}">
                                                                            <label class="form-check-label mr-1"
                                                                                   for="{{$time->id.'_'.$time->time_from.'-'.$time->time_to}}">
                                                                                {{$time->time_from.' : '.$time->time_to}}
                                                                            </label>
                                                                        </div>

                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                            <span style="display: block;text-align: right;"
                                                  class="text-danger error-text save_client_advisory_services_time_id_err"></span>
                                        </div>
                                        <div class="clearfix">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="theme-btn btn-style-three"><span
                                                        class="txt"> تأكيد الطلب </span></button>

                                                <span style="display: none;" id="AjaxLoader" class="">
                                    <img src="{{asset('/site/images/loader2.gif')}}">
                                </span>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </div>
    </section>

@endsection
@section('site_scripts')
    <script>
        $('#make-advisory-services-request-form').on('submit', function (event) {
            event.preventDefault();
            let actionUrl = $(this).attr('action');
            let formData = getFormInputs($(this))
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $("#AjaxLoader").show();
                },
                success: function (response) {

                    if (response.status) {
                        $("#AjaxLoader").hide();
                        location.href = response.payment_url;
                        {{--Swal.fire(--}}
                        {{--    'تهانينا !',--}}
                        {{--    response.msg,--}}
                        {{--    'success'--}}
                        {{--).then(function () {--}}
                        {{--    location.href = '{{route('site.client.service-request.index')}}'--}}
                        {{--})--}}
                    }
                },
                error: function (error) {
                    $("#AjaxLoader").hide();
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.save_client_advisory_services_' + key + '_err').text(value);
                    });
                }

            });

        });
    </script>
@endsection
