@extends('site.layouts.main')
@section('title','اتصل بنا')
@section('content')

    <!-- Page Title -->
    <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
        <div class="auto-container">
            <div class="side-icon">
                <img src="{{asset('site/images/logo.png')}}" alt=""/>
            </div>
            <h2>تواصل معانا</h2>
            <ul class="page-breadcrumb">
                <li><a href="/">الرئيسية</a></li>
                <li>اتصل بنا</li>
            </ul>
            @include('site.website_main_banner')

            @if(Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                <a href="/signin">
                    <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                </a>
            @endif
        </div>
    </section>
    <!-- End Page Title -->

    <!-- Map Section -->
    <section class="contact-map-section">
        <div class="outer-container">
            <!-- Map Boxed -->
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe id="gmap_canvas"
                            src="https://maps.google.com/maps?q={{setting('site.lat')}},{{setting('site.lon')}}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- End Map Section -->

    <!-- Contact Info Section -->
    <section class="contact-info-section">
        <div class="auto-container">
            <div class="inner-container">
                <div class="row clearfix">

                    <!-- Info Box -->
                    <div class="info-box col-lg-3 col-md-6 col-sm-12">
                        <div class="box-inner">
                            <div class="icon flaticon-alarm-clock"></div>
                            <div class="text">{{setting('site.working.hours')}}
                            </div>
                            <h4>ساعات العمل
                            </h4>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="info-box col-lg-3 col-md-6 col-sm-12">
                        <div class="box-inner">
                            <div class="icon flaticon-email-5"></div>
                            <div class="text"><a href="#">{{setting('site.email')}}
                                </a></div>
                            <h4>تواصل معانا عبر
                            </h4>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="info-box col-lg-3 col-md-6 col-sm-12">
                        <div class="box-inner">
                            <div class="icon flaticon-telephone-1"></div>
                            <div class="text">اطلب المساعدة</div>
                            <h4><a href="tel:+22-53-57-554">{{setting('site.phone1')}}</a></h4>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="info-box col-lg-3 col-md-6 col-sm-12">
                        <div class="box-inner">
                            <div class="icon flaticon-pin"></div>
                            <div class="text"> {{setting('site.address')}}
                            </div>
                            <h4>العنوان</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Info Section -->

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="auto-container">
            <div class="inner-container">
                <!-- Sec Title -->
                <div class="sec-title centered">
                    <div class="title">تواصل معانا</div>
                    <h2>تواصل مع فريق الدعم لدينا</h2>
                    <div class="text">أو حدد موعدًا مع مستشارك</div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form">

                    <form method="post" action="{{route('site.contact.save')}}" id="save_contact_message_data_form">
                        @csrf
                        <div class="row clearfix">

                            <div class="col-lg-12 form-group">
                                <select name="user_type" class="form-control" style="height: auto" required>
                                    <option value=""> يرجى تحديد (زائر | مقدم خدمة | عميل)</option>
                                    <option value="مقدم خدمة">مقدم خدمة</option>
                                    <option value="زائر">زائر</option>
                                    <option value="عميل">عميل</option>

                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="name" placeholder="اسمك"  required>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="email" name="email" placeholder="بريدك الالكتروني"  required>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="phone" placeholder="هاتفك"  required>
                            </div>


                            <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                <input type="text" name="subject" placeholder="أدخل الموضوع"  required>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <textarea class="" name="message" placeholder="رسالتك" required></textarea>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 text-center form-group">
                                <button class="theme-btn btn-style-four" id="save_contact_message_data_btn" type="submit" ><span
                                        class="txt">أرسل الآن</span>
                                </button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </section>

@endsection
@section('site_scripts')
    <script>
        $('#save_contact_message_data_form').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');
            let formData = form.serialize();
            $('#save_contact_message_data_btn').attr('disabled','disabled');
            $('#save_contact_message_data_btn').html('<div class="fa fa-spinner fa-spin"></div>');
            $.ajax({
                url : actionUrl,
                type:'post',
                data:formData,
                success:function (response){
                    Swal.fire(
                        'تهانينا !',
                        response.msg,
                        'success'
                    ).then(function (){
                        $('#save_contact_message_data_btn').removeAttr('disabled');
                        $('#save_contact_message_data_btn').html('أرسل الآن');
                        form[0].reset();


                    })
                }
            })
        })
    </script>
@endsection
