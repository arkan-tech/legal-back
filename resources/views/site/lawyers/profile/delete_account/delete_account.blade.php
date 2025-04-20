@extends('site.layouts.main')
@section('title', 'طلب حذف حساب')
@section('content')
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Form Column-->
                <!--Form Column-->
                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title text-center">
                        <h2>طلب حذف حساب</h2>
                        <div class="separate"></div>
                    </div>

                    <!--Login Form-->
                    <div class="styled-form register-form">
                        <form method="post" id="save_lawyer_delete_account_request" action="{{route('site.lawyer.profile.delete-account.post')}}">
                            @csrf

                            <div class="row">
                                @include('site.lawyer_right_menu', array('lawyer'=> $lawyer))
                                <div class="col-lg-1"></div>
                                <div class="col-lg-6">
                                    @if (Session::get('successPostForgotPassword'))
                                        <div
                                            class="alert alert-success">{{ Session::get('successPostForgotPassword') }}</div>
                                    @endif
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                        <input type="hidden" name="lawyer_id" value="{{auth()->guard('lawyer')->user()->id}}">
                                    <div class="form-group ">
                                        <label for="">سبب الحذف</label>

                                        <textarea class="form-control" type="text" name="delete_reason" id="delete_reason" cols="10" rows="5"
                                                  required></textarea>
                                        <span style="display: block;text-align: right;"
                                              class="text-danger error-text development_proposal_err"></span>
                                    </div>


                                    <div class="form-group ">
                                        <label for="">مقترحات التطوير </label>

                                        <textarea class="form-control" type="text" name="development_proposal" id="development_proposal" cols="10" rows="5"
                                                  ></textarea>
                                        <span style="display: block;text-align: right;"
                                              class="text-danger error-text development_proposal_err"></span>
                                    </div>

                                </div>
                                <div class="col-lg-3"></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <div class="clearfix text-center">
                                        <div style="width: 100%" class="form-group pull-left">
                                            <button id="save_lawyer_delete_account_request_btn" type="submit"
                                                    class="theme-btn btn-style-three"><span class="txt">
                                      ارسل الطلب
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
        $('#save_lawyer_delete_account_request').on('submit', function (event) {
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
                    $("#save_lawyer_delete_account_request_btn").attr('disabled','disabled');
                },
                success: function (response) {
                    $("#save_lawyer_delete_account_request_btn").removeAttr('disabled',);

                    if (response.status) {
                        Swal.fire(
                            'تهانينا !',
                            response.msg,
                            'success'
                        ).then(function (){
                            location.reload();
                        })
                    }
                },
                error: function (error) {
                    $("#save_lawyer_delete_account_request_btn").removeAttr('disabled',);
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.' + key + '_err').text(value);
                    });
                }

            });

        });
    </script>
@endsection
