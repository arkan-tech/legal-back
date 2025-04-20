<!DOCTYPE html>
<html>

@include('site.lawyers.electronic_office.layouts.header-style')

<body lang="en" dir="rtl">



<div class="page-wrapper text-right">
    <!-- Preloader -->
    @yield('electronic_office_header')
    @yield('electronic_office_content')
    @include('site.lawyers.electronic_office.layouts.footer')
</div>
<!--End pagewrapper-->

<!-- Scroll To Top -->
{{--<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>--}}



</body>
@include('site.lawyers.electronic_office.layouts.footer-js')
</html>
