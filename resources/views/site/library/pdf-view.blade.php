@extends('site.layouts.main')
@section('title', "$sectitle")
@section('content')

    <style>
        .add-to-favorite i {}

        @media (min-width: 768px) {
            .modal-xl {
                width: 90%;
                max-width: 1200px;
            }
        }
    </style>
    <style>
        .tooltipClib {
            position: relative;
            display: inline-block;

        }

        .tooltipClib .tooltiptextClib {
            visibility: hidden;
            width: 140px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -75px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltipClib .tooltiptextClib::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltipClib:hover .tooltiptextClib {
            visibility: visible;
            opacity: 1;
        }
    </style>
    <style>
        i {
            cursor: pointer;
            padding: 10px 12px 8px;
            background: #fff;
            border-radius: 50%;
            display: inline-block;
            margin: 0 0 15px;
            color: #aaa;
            transition: .1ms;
        }

        i:hover {
            color: #666;
        }

        i:before {
            font-family: fontawesome;
            content: '\f004';
            font-style: normal;
        }

        span {
            position: absolute;
            bottom: 70px;
            left: 0;
            right: 0;
            visibility: hidden;
            transition: .1ms;
            z-index: -2;
            font-size: 2px;
            color: transparent;
            font-weight: 400;
        }

        i.press {
            animation: size .1ms;
            color: #e23b3b;
        }

        span.press {
            bottom: 120px;
            font-size: 14px;
            visibility: visible;
            animation: fade 0.1ms;
        }

        @keyframes fade {
            0% {
                color: #transparent;
            }

            50% {
                color: #e23b3b;
            }

            100% {
                color: #transparent;
            }
        }

        @keyframes size {
            0% {
                padding: 10px 12px 8px;
            }

            50% {
                padding: 14px 16px 12px;
                margin-top: -4px;
            }

            100% {
                padding: 10px 12px 8px;
            }
        }
    </style>

    <!-- Page Title -->
    <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
        <div class="auto-container">
            <div class="side-icon">
                <img src="{{asset('site/images/logo.png')}}" alt="" />
            </div>
            <h2>
                {{ $sectitle }}
            </h2>
            <ul class="page-breadcrumb">
                <li><a href="/">الرئيسية</a></li>
                <li><a href="{{route('site.library.index') }}">المكتبه</a></li>
                <li><a href="{{route('site.library.view',$BK->id)}}">{{ $BK->title }}</a></li>
                <li>{{ $sectitle }}</li>
            </ul>
            @include('site.website_main_banner')
            @if (Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                <a href="/signin">
                    <a target="_blank" href="{{route('site.lawyer.show.login.form')}}" style="color: white"> <div class="side-tag"> بادر بحجز مكتبك الالكتروني فوراً </div></a>

                </a>
            @endif
        </div>
    </section>
    <!-- End Page Title -->
    <!-- About Section -->
    <section class="about-section">
        <div class="auto-container">
            <ul class="page-breadcrumb mb-5">
                <li><a href="/" style="color: #dd9b25">الرئيسية</a></li>
                <li>/</li>
                <li><a href="{{ route('site.library.index') }}" style="color: #dd9b25">المكتبه</a></li>
                <li>/</li>
                <li><a href="{{route('site.library.view',$BK->id)}}" style="color: #dd9b25">{{ $BK->title }}</a></li>
                <li>/</li>
                <li>{{ $sectitle }}</li>
            </ul>
            <div class="row clearfix">
                <!-- Image Column -->
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="image wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <img src="{{$Book->Image }}"
                                alt="" />
                        </div>
                    </div>
                </div>
                <!-- Content Column -->
                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- Sec Title -->
                        <div class="sec-title">
                            <div class="title"> النبذه عن الكتاب </div>
                            <h2>{{$Book->Title}}
                                @if (Session::get('loggedInClientID') == '' && Session::get('loggedInUserID') == '')
                                    <i></i>
                                    <span>اضافه للمفضله</span>
                                @endif
                            </h2>
                        </div>
                        <hr>
                        <div class="text">
                            <p>{!! @$Book->details !!}</p>
                        </div>
                        <hr>
                        <div class="text">
                            <a href="{{$Book->Link }}" target="_blank" class="btn  btn-lg"
                                style="  border: 2px solid rgb(5, 5, 5); background-color: #dd9b25 ; color: white">
                                فتح الملف
                            </a>
                            <div id="myModal" class="modal fade  bd-example-modal-xl" role="dialog">
                                <div class="modal-dialog modal-xl">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <embed src="{{asset('uploads/'.$Book->Link) }}" frameborder="0" width="100%"
                                                height="760px">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">اغلاق</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text">
                            <p>مشاركه الملف</p>
                            <div class="row">
                                    <div class="tooltipClib">
                                        <button class="p-2 "  onclick="myFunction()" >
                                            <img width="20px" height="20px" src="{{ asset('copy.png') }}" alt="انسخ"></button>
                                    </div>
                                <div class="col-1"></div>

                                <button class="p-2"  id="share-button">
                                    <img width="20px" height="20px" src="{{ asset('whatsapp.png') }}"
                                            alt="ارسل">
                                </button>
                                <input type="text" hidden value="{{ route('site.about.book', ['id' => $Book->id]) }}"
                                style=" border: 2px solid rgb(90, 90, 90)" id="myInput">

                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="law-image">
                <img src="{{asset('site/images/law.png')}}" alt="" />
            </div>
        </div>
    </section>
    <!-- End About Section -->




    <script>
           var copyText = document.getElementById("myInput");
        function myFunction() {
            // var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            Swal.fire(
                'تهانينا !',
                'تم نسخ : ' + copyText.value,
                'success'
            )
            // var tooltip = document.getElementById("myTooltip");
            //
            // tooltip.innerHTML = "تم نسخ: " + copyText.value;
        }

        function outFunc() {
            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "انسخ النص";
        }
        $(function() {
            $("i").click(function() {
                $("i,span").toggleClass("press", 10);
            });
        });

        const shareButton = document.getElementById("share-button");
        const link = copyText.value;

        shareButton.addEventListener("click", function() {
            window.open("https://wa.me/?text=" + encodeURIComponent(link));
        });
    </script>

@endsection
