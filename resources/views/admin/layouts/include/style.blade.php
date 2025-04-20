<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
          content="GymBoost Dashboard.">
    <meta name="keywords"
          content="GymBoost Dashboard">
    <meta name="author" content="PIXINVENT">
    <title>لوحة تحكم يمتاز</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <link rel="apple-touch-icon" href="{{asset('admin/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('admin/app-assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    @yield('style')

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/vendors-rtl.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/pages/app-chat.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/pages/app-chat-list.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="{{asset('admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/plugins/charts/chart-apex.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('admin/app-assets/css-rtl/plugins/extensions/ext-component-toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/pages/app-invoice-list.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/forms/select/select2.min.css')}}">
    <!-- END: Page CSS-->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/custom-rtl.css')}}">
    <!-- END: Custom CSS-->
<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:400,500);
    @import url(https://fonts.googleapis.com/earlyaccess/notosanskannada.css);

    @font-face {
        font-family: 'Droid Arabic Kufi';
        font-style: normal;
        font-weight: 400;
        src: url(//themes.googleusercontent.com/static/fonts/earlyaccess/droidarabickufi/v2/DroidKufi-Regular.eot?#iefix) format('embedded-opentype'),
        url(//themes.googleusercontent.com/static/fonts/earlyaccess/droidarabickufi/v2/DroidKufi-Regular.woff) format('woff'),
        url(//themes.googleusercontent.com/static/fonts/earlyaccess/droidarabickufi/v2/DroidKufi-Regular.ttf) format('truetype');
    }

    body {
        font-family: 'Droid Arabic Kufi', 'Roboto', play, Arial, Helvetica, sans-serif;
        font-size: 13px;
        line-height: 1.8;
    }

    .navigation {
        font-family: 'Droid Arabic Kufi', 'Roboto', play, Arial, Helvetica, sans-serif;
        font-size: 15px;
        line-height: 1.8;
    }

    .navigation-header {
        font-family: 'Droid Arabic Kufi', 'Roboto', play, Arial, Helvetica, sans-serif !important;
        font-size: 12px !important;
        line-height: 1.8 !important;
    }

    .dropdown-user{
        font-family: 'Droid Arabic Kufi', 'Roboto', play, Arial, Helvetica, sans-serif !important;
        font-size: 12px !important;
        line-height: 1.8 !important;
    }
</style>
</head>
<!-- END: Head-->
