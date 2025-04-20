<nav class="navbar navbar-expand-lg navbar-light bg-light " style="padding-top:0 ">
    <div class="container">
        <a class="navbar-brand" href="#" style="padding-top:0 ">
            <img class="img-logo" src="{{asset('site/images/logo.png')}}"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav " style="margin-right: 50%">
                <li class="nav-item ">
                    <a class="nav-link" href="{{route('site.lawyer.electronic-office.home',$id)}}">الرئيسية </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('site.lawyer.electronic-office.services',$id)}}">خدمات المكتب</a>
                </li>

{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link">محفظتنا</a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('site.lawyer.electronic-office.clients',$id)}}">عملائنا</a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link " href="{{route('site.lawyer.electronic-office.blog',$id)}}">المدونة</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link">من نحن</a>--}}
{{--                </li>--}}
            </ul>

        </div>
        @if(auth()->guard('lawyer_electronic_office')->check())
            <div class="dropdown">
                <button class="btn login dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    الملف الشخصي
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{route('site.lawyer.electronic-office.dashboard.index',$id)}}">
                        الملف الشخصي</a>
                    <a class="dropdown-item" href="{{route('site.lawyer.electronic-office.logout',$id)}}"> تسجيل
                        خروج </a>
                </div>
            </div>
        @else
            <div>
                <a class="btn login" href="{{route('site.lawyer.electronic-office.login.form',$id)}}"> تسجيل الدخول الى
                    لوحتك</a>
            </div>
        @endif
    </div>
</nav>
