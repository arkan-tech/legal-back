@extends('site.layouts.main')
@section('title', 'البحث ')
@section('content')




    <!-- Page Title -->
    <section class="page-title" style="background-image: url(site/images/background/8.jpg)">
        <div class="auto-container">
            <div class="side-icon">
                <img src="site/images/logo.png" alt="" />
            </div>
            <h2> البحث </h2>
            <ul class="page-breadcrumb">
                <li><a href="/">الرئيسية</a></li>
                <li><a href="{{ route('site.library.index') }}">المكتبه</a></li>
                <li> البحث</li>
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

    <section class="pricing-section digital_guide">
        <div class="auto-container">
            <ul class="page-breadcrumb mb-5">
                <li><a href="/" style="color: #dd9b25">الرئيسية</a></li>
                <li> / </li>
                <li><a href="{{ route('site.library.index') }}" style="color: #dd9b25">المكتبه</a></li>
                <li> /</li>
                <li> البحث</li>
            </ul>
            <!-- Sec Title -->
            <div class="sec-title centered">
                <div class="title"> البحث </div>
                <h2> اقسام المكتبه </h2>
            </div>


            <div class="row clearfix">

                @isset($Librarycats)
                    @foreach ($Librarycats as $Librarycat)
                        <div class="price-block col-lg-3 col-md-4 col-sm-9">
                            <div class="inner-box" style="background-image:url(site/images/background/pattern-7.png)">
                                <div class="color-one-layer"></div>
                                <div class="color-two-layer"></div>
                                <div class="icon flaticon-civil-right"></div>
                                <div class="side-icon flaticon-civil-right"></div>
                                <div class="price"><span>{{ $Librarycat->title }}</span>
                                    {{-- <?= GetSectionCount($Librarycat->id) ?> --}}
                                </div>
                                <a href="/libraryview/{{ $Librarycat->id }}"class="theme-btn btn-style-four"><span
                                        class="txt">عرض </span></a>
                            </div>
                        </div>
                    @endforeach
                @endisset


            </div>
            <div class="sec-title centered">
                <div  class="title"></div>
                <h2> الكتب </h2>
            </div>
            <div class="row clearfix">

                @isset($Books)
                    @foreach ($Books as $Book)
                        <div class="price-block col-lg-2 col-md-3 col-sm-6">
                            <div class="inner-box" style="background-image:url(site/images/background/pattern-7.png)">
                                <div class="color-one-layer"></div>
                                <div class="color-two-layer"></div>
                                <div class="price"><span>
                                       {{mb_strlen($Book->Title) > 25 ? mb_substr($Book->Title, 0, 25, 'UTF-8') . ' ...' : $Book->Title}}</span>
                                </div>
                                <a href=" {{ route('site.about.book', ['id' => $Book->id]) }} " class="theme-btn btn-style-four"><span
                                        class="txt">عرض </span></a>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </section>

@endsection
