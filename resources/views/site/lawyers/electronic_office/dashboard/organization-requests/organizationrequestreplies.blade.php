@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 15% ;margin-bottom: 15%">
                <h2> لوحة التحكم </h2>
            </div>
        </div>
        <section class="page-banner">
            <div class="image-layer"></div>
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1></h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a></a></li>
                                <li class="active"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
@section('electronic_office_content')

    <!-- Contact Form Section -->
    <div class="row " style="max-width: 100%">
        @include('site.lawyers.electronic_office.dashboard.layouts.side_menue')

        <!--Login Form-->
        <div class="col-lg-9  mt-3 mb-3">
            <div class="auto-container">
                <div class="">
                    <div class="row">

                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="row clearfix">

                                <ul class="chats">

                                    @include('site.lawyers.electronic_office.dashboard.organization-requests.vieworganizationrequestreplies',['replies','consultation'])

                                </ul>
                            </div>

                            <form id="writeReplyOffice"
                                  action="{{ route('site.lawyer.electronic-office.dashboard.organization-request.saveorganizationrequestreply') }}">
                                @csrf
                                <div class="row clearfix">
                                    <input type="hidden" value="{{ $consultation->id }}"
                                           name="mainConsultation">
                                    <input type="hidden" value="{{ $id }}"
                                           name="electronic_id_code">

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <textarea class="form-control" required cols="5" rows="5" name="reply"
                                                          placeholder="الرد على الإستشارة"></textarea>

                                        <span style="display: block;text-align: right;color: #dc3545!important"
                                              class="mail-text-danger error-text reply_error"></span>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 text-center form-group">
                                        <button class="theme-btn btn-style-four" type="submit"
                                                name="submit-form"><span class="txt"> ارســـال </span></button>

                                        <span style="display: none;" id="AjaxLoader" class="">
                                                         <img src="{{asset('site/images/loader2.gif')}}">
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
@endsection

@section('electronic_office_site_scripts')
    <script>
        $('#writeReplyOffice').on('submit', function (event) {
            event.preventDefault();
            $.ajax
            ({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $("#AjaxLoader").show();
                },
                success: function (data) {
                    $("#writeReplyOffice")[0].reset();
                    $('.text-danger').hide();
                    $("#AjaxLoader").hide();
                    $('.chats').html(data.chats);

                },
                error: function (error) {
                    $.each(data.error, function (key, value) {
                        $('.' + key + '_error').text(value);
                    });
                }
            });
        });
    </script>

@endsection
