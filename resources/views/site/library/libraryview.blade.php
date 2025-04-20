    @extends('site.layouts.main')
    @section('title',"$sectitle")
    @section('content')

    <style>
        .add-to-favorite i{

        }
    </style>
            <!-- Page Title -->
            <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
                <div class="auto-container">
                    <div class="side-icon">
                        <img src="{{asset('site/images/logo.png')}}" alt="" />
                    </div>
                    <h2>
                        {{$sectitle}}
                    </h2>
                    <ul class="page-breadcrumb">
                        <li><a href="/" >الرئيسية</a></li>
                        <li><a href="{{ route('site.library.index') }}" >المكتبه </a></li>
                        <li>{{$sectitle}}</li>
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

            <section class="counter-section-two list_books" >
                <div class="auto-container d-flex flex-row">
                    <ul class="page-breadcrumb ">
                        <li><a href="/" style="color: #dd9b25">الرئيسية</a></li>
                        <li>/</li>
                        <li><a href="{{route('site.library.index') }}"style="color: #dd9b25">المكتبه </a></li>
                        <li>/</li>
                        <li>{{$sectitle}}</li>
                    </ul>
                    </div>
                <div class="auto-container">
                    <div class="sec-title centered">
                        <div class="title">
                        </div>
                        <h2>
                            {{$sectitle}}
                        </h2>
                    </div>
                    <!-- Fact Counter -->
                    <div class="fact-counter-two">
                        <div class="row clearfix">
                        @foreach($Books as $Book)
                            <div class="column counter-column">
                                <div class="inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                                    <div class="line-one"></div>
                                    <div class="line-two"></div>
                                    <div class="content">
                                        <div class="">
                                            <img src="{{$Book->Image}}" class="">
                                        </div>
                                        <div class="counter-title" style="text-align: right; padding-right: 20px;">
                                            <a style="padding-top: 10px; min-height: 65px; display: inline-block;" target="_blank" href=" {{ route('site.about.book',['id'=>$Book->id]) }} ">
                                                    {!!(mb_strlen($Book->Title) > 25) ? mb_substr($Book->Title, 0, 25, "UTF-8").' ...' : $Book->Title  !!}
                                            </a>
                                        </div>
                                        @if(Session::get('loggedInUserID') != '')
                                            @if(GetName('lawyers', 'office_request_status', 'id', Session::get('loggedInUserID')) == 1)
                                                @if(checkFavorite(Session::get('loggedInUserID'), $Book->id))
                                                    <a href="#" data-id="{{ Session::get('loggedInUserID') }}" data-book-id="{{ $Book->id }}" class="check-favorite">
                                                        <i class="fa fa-heart"></i>
                                                    </a>
                                                @else
                                                    <a href="#" data-id="{{ Session::get('loggedInUserID') }}" data-book-id="{{ $Book->id }}" class="check-favorite">
                                                        <i class="fa fa-heart-o"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </section>
    @endsection
