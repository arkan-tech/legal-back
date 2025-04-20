@extends('site.layouts.main')
@section('title',$building->title)
@section('content')
    <!-- Page Title -->
    <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
        <div class="auto-container">
            <div class="side-icon">
                <img src="{{asset('images/logo.png')}}" alt=""/>
            </div>
            <h2>{{ $building->title }}</h2>
            @if(Session::get('loggedInUserID') != '')
                @if(GetName('lawyers', 'office_request', 'id', Session::get('loggedInUserID')) == 1)
                    @if(GetName('lawyers', 'office_request_status', 'id', Session::get('loggedInUserID')) == 1)
                        @php
                            $lawyerEmail = GetName('lawyers', 'Email', 'id', Session::get('loggedInUserID'));
                            $lawyerPassword = GetName('lawyers', 'Password', 'id', Session::get('loggedInUserID'));
                            $lawyerPaidStatus = GetName('lawyers', 'paid_status', 'id', Session::get('loggedInUserID'));
                        @endphp
                        @if($lawyerPaidStatus == 1)
                            <a target="_blank"
                               href="https://lawyer.ymtaz.sa/dashboard?email={{ $lawyerEmail }}&password={{ $lawyerPassword }}">
                                <div class="side-tag">
                                    المكتب الإلكترونى
                                </div>
                            </a>
                        @else
                            <a href="/show-payment-rules">
                                <div class="side-tag">
                                    قم باتمام الدفع
                                </div>
                            </a>
                        @endif
                    @endif
                @else
                    <a data-id="{{ Session::get('loggedInUserID') }}" class="apply-office_" href="#">
                        <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                    </a>
                @endif
            @endif
            @if(Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                <a href="/signin">
                    <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                </a>
            @endif
        </div>
    </section>
    <!-- End Page Title -->
    <!-- Team Detail Section -->
    <section class="team-detail-section">
        <div class="auto-container">
            <div class="upper-box">
                <div class="row clearfix">
                    <!-- Image Column -->
                    <div class="image-column col-lg-4 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="image">
                                <img src=" {{('uploads/'.$building->image)}}" alt="{{ $building->title }}"/>
                            </div>
                        </div>
                    </div>
                    <!-- Content Column -->
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="title"></div>
                            <div class="name_lawyer">
                                <h2>{{ $building->title }}</h2>
                            </div>
                            <div class="designation">{!! $building->intro !!}</div>
                            <h3 class="mt-4"> التواصل </h3>
                            <ul class="tag-list clearfix">
                                <li><a href="mailto:{{ $building->email }}"> <i class="fa fa-envelope"></i> </a></li>
                                <li><a href="tel:{{ $building->phone }}"> <i class="fa fa-phone"></i> </a></li>
                                <li><a target="_blank"
                                       href="https://maps.google.com/?q={{ $building->latitude }},{{ $building->longitude }}"><i
                                            class=" fa fa-map-marker"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
