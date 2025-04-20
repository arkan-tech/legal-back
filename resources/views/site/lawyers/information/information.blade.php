@extends('site.layouts.main')
@section('title','بياناتي')
@section('content')
    <style>
        .apply-office {
            font-family: 'Tajawal Bold';
        }

        .links {
            font-size: 20px;
            font-weight: 700
        }

        .links:hover {
            color: #dd9b25
        }

        a.active {
            color: #000
        }

        .table-inbox {
            border: 1px solid #d3d3d3;
            margin-bottom: 0;
        }

        .table > tbody > tr > td {
            border-top: 1px solid #ddd;
        }

        .table-inbox tr td {
            padding: 10px !important;
            vertical-align: middle;
            text-align: center;
        }

        .inbox-head {
            background: none repeat scroll 0 0 #dd9b25;
            border-radius: 0 4px 0 0;
            color: #fff;
            min-height: 80px;
            padding: 20px;
        }

        .send-mail {
            font-size: 15px;
            padding: 5px;
        }

        .avatar {
            width: 50px;
            border-radius: 50%;
        }

        .modal-header h2 {
            font-size: 25px;
        }

        .modal-content {
            direction: rtl;
        }

        #reason label {
            float: right
        }

        .modal-footer a, .modal-footer button {
            padding: 8px 25px;
            margin-left: 15px;
        }
    </style>

    <!-- Contact Form Section -->
    <section class="register-section">
        <div class="auto-container">
            <div class="row clearfix">


                <div class="form-column column col-lg-12 col-md-12 col-sm-12">

                    <div class="sec-title">
                        <h2> المعلومات الشخصية </h2>
                        <div class="separate"></div>
                    </div>
                    <!--Login Form-->
                    <div class="styled-form">
                        <div class="row">
                            @include('site.lawyer_right_menu', array('lawyer'=> $lawyer))
                            <div class="col-lg-9">
                                <div class="col-lg-12 ">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h4 class="card-title">معلومات الشخصية</h4>
                                        </div>
                                        <div class=" my-25 p-2">
                                            <div class="d-flex">
                                                <img src="{{$lawyer->photo}}"
                                                     id="account-upload-img" class="uploadedAvatar rounded me-50"
                                                     alt="profile image" height="100" width="100"/>
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountFirstName"> الاسم </label>
                                                <span type="text" class="form-control">{{$lawyer->name}}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountEmail"> كود الدولة</label>
                                                <span type="text"
                                                      class="form-control">{{'+'.$lawyer->phone_code}}</span>
                                            </div>
                                            <div class="col-12 col-sm-3 mb-1">
                                                <label class="form-label" for="accountEmail">رقم الجوال</label>
                                                <span type="text" class="form-control">{{$lawyer->phone}}</span>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountEmail">تاريخ الميلاد</label>
                                                <span type="text" class="form-control">{{$lawyer->birthday}}</span>
                                            </div>

                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountEmail"> الجنس</label>
                                                <span type="text" class="form-control">{{$lawyer->gender}}</span>
                                            </div>
                                            <div class="col-12 col-sm-12 mb-1">
                                                <label class="form-label" for="accountEmail">تعريف مختصر :</label>
                                                <textarea class="form-control" rows="5" disabled>
                                                {{$lawyer->about}}
                                            </textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 row mt-1">
                                            <div class="col-lg-4 col-sm-4 mb-1">
                                                <label class="form-label" for="accountEmail">الجنسية </label>
                                                <span type="text" class="form-control">{{$nationality->name}}</span>

                                            </div>
                                            <div class="col-lg-4 col-sm-4 mb-1">
                                                <label class="form-label" for="accountEmail">الدولة </label>
                                                <span type="text" class="form-control">{{$countries->name}}</span>

                                            </div>
                                            <div class="col-lg-4 col-sm-4 mb-1">
                                                <label class="form-label" for="accountEmail">المنطقة </label>
                                                <span type="text" class="form-control">{{$regions->name}}</span>

                                            </div>
                                        </div>
                                        <div class="col-lg-12 row mt-1">
                                            <div class="col-lg-4 col-sm-6 mb-1">
                                                <label class="form-label" for="accountEmail">المدينة </label>
                                                <span type="text" class="form-control">{{$cities->title}}</span>
                                            </div>
                                        </div>
                                    </div>

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
        $(document).ready(function () {
            let identity_type_status = '{{$lawyer->identity_type}}';
            let degree_status = '{{$lawyer->degree}}';
            let has_licence_no = '{{$lawyer->has_licence_no}}';
            let is_advisor = '{{$lawyer->is_advisor}}';
            let lawyer_type = '{{$lawyer->type}}';
            let digital_guide_subscription_value = '{{$lawyer->digital_guide_subscription}}';
            let other_city = '{{$lawyer->city}}';

            if (identity_type_status == 4) {
                var other_idetity_type_dev = document.getElementById("other_idetity_type_dev");
                other_idetity_type_dev.style.display = "block"
            }

            if (degree_status == 4) {
                var other_degree_dev = document.getElementById("other_degree_dev");
                other_degree_dev.style.display = "block"
            }

            // if (has_licence_no == 1) {
            //     var other_degree_dev = document.getElementById("licence_no_dev");
            //     other_degree_dev.style.display = "block"
            // } else {
            //     var other_degree_dev = document.getElementById("licence_no_dev");
            //     other_degree_dev.style.display = "none"
            // }

            if (is_advisor == 1) {
                var advisor_cat_id_div = document.getElementById("advisor_cat_id_div");
                advisor_cat_id_div.style.display = "block"
            }
            if (digital_guide_subscription_value == 1) {
                $('#digital_guide_subscription_from_to_div').removeClass('d-none')
            }
            if (other_city == 0) {
                $('#other_city_dev').removeClass('d-none')
            }

            if (lawyer_type == 1) {
                $('#company_name_div').css('display', 'none');
                $('#lisences_div').css('display', 'none');
                $('#other_entity_name_div').css('display', 'none');
            } else if (lawyer_type == 2 || lawyer_type == 3) {
                $('#company_name_div').css('display', 'block');
                $('#lisences_div').css('display', 'block');
                $('#other_entity_name_div').css('display', 'none');
            } else if (lawyer_type == 4 || lawyer_type == 5 || lawyer_type == 6) {
                $('#company_name_div').css('display', 'none');
                $('#lisences_div').css('display', 'none');
                $('#other_entity_name_div').css('display', 'block');
            }


        })
    </script>
@endsection
