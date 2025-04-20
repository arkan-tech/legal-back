@extends('site.layouts.main')
@section('title',' حسابى الشخصى ')
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
            padding: 15px !important;
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

        .avatar {
            width: 50px;
            border-radius: 50%;
        }
    </style>

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

                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <div class="styled-form register-form">
                                    <form id="client-update">
                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for=""> الاسم</label>
                                                    <span class="form-control">{{ $client->myname }}</span>

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">رقم الجوال</label>
                                                    <span class="form-control">{{ $client->mobil }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for=""> الايميل</label>
                                                    <span class="form-control">{{ $client->email }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for=""> الدولة</label>
                                                    <span class="form-control">{{ $client->country->name }}</span>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="row">
                                            @if(!is_null($client->city))
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for=""> المدينة</label>
                                                    <span class="form-control">{{!is_null($client->city)? $client->city->title:'' }}</span>
                                                </div>
                                            </div>
                                            @endif
                                            @if($client->nationality)
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for=""> الجنسية</label>
                                                    <span class="form-control">{{ !is_null($client->nationality)? $client->nationality->name:''  }}</span>
                                                </div>

                                            </div>
                                                @endif
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for=""> الصفة</label>
                                                        <span class="form-control">{{getClientType($client->type)  }}</span>
                                                    </div>
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
