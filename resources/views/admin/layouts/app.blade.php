<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

@include('admin.layouts.include.style')
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="">

<!-- BEGIN: Header-->
@include('admin.layouts.include.header')
<!-- END: Header-->

<!-- BEGIN: Main Menu-->
@include('admin.layouts.include.aside')
<!-- END: Main Menu-->


<!-- BEGIN: Content-->
@yield('content')
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
@include('admin.layouts.include.footer')
<!-- END: Footer-->


<!-- BEGIN: Scripts-->
@include('admin.layouts.include.scripts')
<!-- END: Scripts-->

</body>
<!-- END: Body-->

</html>
