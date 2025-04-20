@extends('site.layouts.main')
@section('title','تفعيل الحساب')
@section('content')

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Form Column-->
                <!--Form Column-->
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title text-center">
                        <h2>الرجاء ادخال الرمز للتفعيل </h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form method="post" action="{{route('site.client.post.activate.sms.form')}}"
                              id="sms_post_activate_form">
                            @csrf
                            <input type="hidden" name="email" value="{{$email}}">
                            <input type="hidden" name="phone" value="{{$phone}}">
                            <input type="hidden" name="phone_code" value="{{$phone_code}}">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">الرمز</label>
                                        <input type="text" class="form-control" name="otp" id="otp"
                                               placeholder="الرمز"
                                               maxLength="4"
                                               oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <div class="clearfix text-center">
                                        <div style="width: 100%" class="form-group pull-left">
                                            <button id="activate_lawyer_btn" type="submit"
                                                    class="theme-btn btn-style-three"><span class="txt">
                                         تفعيل الحساب
                                        </span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>


                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
@section('site_scripts')
    <script>
        function getFormInputs(formId) {
            return new FormData(formId[0]);
        }

        function disableAndLoadingButton(selector, loadingText) {
            selector.attr('disabled', true).html('<div class="fa fa-spinner fa-spin"></div> ' + loadingText);
        }

        function enableAndLoadingButton(selector, normalText) {
            selector.attr('disabled', false).html(normalText);
        }

        $('#sms_post_activate_form').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = getFormInputs(form);
            let actionUrl = form.attr('action');
            $btn = $('#activate_lawyer_btn');
            $.ajax({
                url: actionUrl,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    disableAndLoadingButton($btn, "جاري التحقق..");
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire(
                            'تهانينا !',
                            response.msg,
                            response.title,
                        ).then(function () {
                            location.href = '{{route('site.lawyer.show.login.form')}}';
                        })
                    } else {
                        Swal.fire(
                            'خطأ !',
                            response.msg,
                            response.title,
                        ).then(function () {
                            enableAndLoadingButton($btn, "تفعيل الحساب");
                        })
                    }
                },
                error: function (error) {
                    enableAndLoadingButton($btn, "تفعيل الحساب");
                    console.log(error.responseJSON.errors);
                    Swal.fire(
                        '  خطأ !',
                        'هناك بعض الاخطاء في البيانات  !',
                        'error'
                    )


                }
            });
        });
    </script>
@endsection
