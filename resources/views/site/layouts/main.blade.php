<!DOCTYPE html>
<html>

@include('site.layouts.header-style')

<body lang="en" dir="rtl">
<div class="page-wrapper">
    <!-- Preloader -->
    @include('site.layouts.header')
    @yield('content')
    @include('site.layouts.footer')
</div>
<!--End pagewrapper-->

<!-- Scroll To Top -->
<div class="scroll-to-top scroll-to-target" data-target="html">
    <span class="fa fa-angle-up"></span>
</div>


</body>
@include('site.layouts.footer-js')
</html>
