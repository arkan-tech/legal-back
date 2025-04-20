@extends('site.layouts.main')
@section('title', 'المكتبة')
@section('content')
    <!-- Page Title -->
    <section class="page-title" style="background-image: url('{{asset('site/images/background/8.jpg')}}')">
        <div class="auto-container">
            <div class="side-icon">
                <img src="{{asset('site/images/logo.png')}}" alt="" />
            </div>
            <h2>المكتبة </h2>
            <ul class="page-breadcrumb">
                <li><a href="/">الرئيسية</a></li>
                <li>المكتبة </li>
            </ul>
            @include('site.website_main_banner')

        </div>
    </section>
    <!-- End Page Title -->
    <div class="sidebar-page-container libraries">
        <div class="auto-container">
            <ul class="page-breadcrumb mb-5">
                <li ><a href="/" style="color: #dd9b25">الرئيسية</a></li>
                <li>/</li>
                <li>المكتبة </li>
            </ul>
            <form action="{{ route('site.library.search') }}" method="GET">
            <div class="row clearfix ">
                <div class="col-4">
                <h4 class="form-outline mb-2" > البحث </h4>
                <div class="input-group sidebar-title">
                    <input type="search" name="search" class="form-control rounded" placeholder="اسم الكتاب او اسم القسم او اسم القسم الفرعي" aria-label="Search" aria-describedby="search-addon" />
                    <button type="submit"   class="btn btn-outline" style=" border: 2px solid rgb(5, 5, 5); background-color: #dd9b25 ; color: white">ابحث</button>
                  </div>
                </div>
                <div class="col-4"></div>
            </div>
        </form>
            <div class="row clearfix">
                <!-- Sidebar Side -->
                <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar sticky-top">
                        <!-- Categories Widget -->
                        <div class="sidebar-widget categories-widget">
                            <div class="widget-content">
                                <!-- Sidebar Title -->
                                <div class="sidebar-title">
                                    <h3>اقسام المكتبة </h3>
                                </div>
                                <ul class="nav nav-tabs blog-cat" role="tablist">
                                    @foreach ($Librarycats as $Librarycat)
                                        <li>
                                            <a data-toggle="tab" href="#tabs-{{ $Librarycat->id }}" class="{{($loop->first) ? 'active' : ''}}"
                                                role="tab">{{ $Librarycat->title }}<span>{{ GetLibCount($Librarycat->id) }}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
                <!-- Content Side -->
                <div class="content-side col-lg-8 col-md-12 col-sm-12">
                    <div class="tab-content">
                        @foreach ($Librarycats as $Librarycat)
                            <div class="tab-pane {{($loop->first) ? 'active' : ''}}" id="tabs-{{ $Librarycat->id }}" role="tabpanel">
                                <div class="our-shops">
                                    <!--Shop Single-->
                                    <div class="shop-section">
                                        <!--Sort By-->
                                        <div class="items-sorting">
                                            <div class="row clearfix">
                                                <div class="results-column col-md-12">
                                                    <h6 class="text-center">{{ $Librarycat->title }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="our-shops">
                                            <div class="row clearfix">
                                                @php $BKS = GetBooksSubCat($Librarycat->id);@endphp
                                                @foreach ($BKS as $BK)
                                                    <div
                                                        class="single-product-item col-lg-4 col-md-6 col-sm-12 text-center">
                                                        <div class="img-holder">
                                                            <img width="270" height="300"
                                                                src="{{asset('uploads/library/'.$BK->image) }}"
                                                                class="" alt="">
                                                        </div>
                                                        <div class="title-holder text-center">
                                                            <div class="static-content">
                                                                <h3 class="title text-center">
                                                                    <a href="{{route('site.library.view', $BK->id) }}">{{ $BK->title }}</a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- Post Share Options -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
