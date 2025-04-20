<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Stylesheets -->
    <link href="{{asset('site/css/bootstrap.css')}}" rel="stylesheet"/>
    <link href="{{asset('site/css/style.css')}}" rel="stylesheet"/>
    <link href="{{asset('site/css/responsive.css')}}" rel="stylesheet"/>
    <link href="{{asset('site/css/style_ar.css')}}" rel="stylesheet"/>
    <link href="{{asset('site/css/select2/select2.min.css')}}" rel="stylesheet"/>

    <!-- Color Switcher Mockup -->
    <link href="{{asset('site/css/color-switcher-design.css')}}" rel="stylesheet"/>
    <!-- Color Themes -->
    <link id="theme-color-file" href="{{asset('site/css/color-themes/default-theme.css')}}" rel="stylesheet"/>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&family=Roboto:wght@300;400;500;700;900&display=swap"
        rel="stylesheet"/>
    <link rel="shortcut icon" href="{{asset('site/images/logo.png')}}" type="image/x-icon"/>
    <link rel="icon" href="{{asset('site/images/logo.png')}}" type="image/x-icon"/>
    <!-- Responsive -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]>
    <script src="{{asset('site/js/respond.js')}}"></script><![endif]-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <style type="text/css">
        .main-menu .navigation > li {
            margin-left: 0px;
        }

        .frgt-pswd {
            padding-top: 15px;
        }

        .frgt-pswd:hover {
            color: #dd9b25;
        }

        .dropdown-item {
            font-family: 'Tajawal Regular' !important;
            text-align: right;
        }

        .select2 {
            /*height: 50%;*/
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }


        #birthday {
            border: 1px solid #f4f4f4;
            border-radius: 0px;
            height: 50px
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            float: right;
        }

        .select2-container--default .select2-search--inline .select2-search__field,
        .select2-results__option[aria-selected] {
            text-align: right
        }

        .main-menu .navigation > li > a {
            padding: 20px 11px;
        }

        .content-box p {
            color: #fff !important;
        }

        .close {
            float: left !important;
        }

        .messages-count {
            position: absolute;
            top: 3px;
            left: 0;
            background: #DD9B25;
            color: #fff;
            border-radius: 50%;
            padding: 0px 12px;
            font-size: 11px;
        }

        .main-menu .navigation > li:hover > a span.messages-count,
        .main-menu .navigation > li.current > a span.messages-count {
            color: #DD9B25;
            background-color: #fff !important;
        }


        .lawyer-messages-count {
            position: absolute;
            top: 3px;
            left: 0;
            background: #DD9B25;
            color: #fff;
            border-radius: 50%;
            padding: 0px 12px;
            font-size: 11px;
        }

        .main-menu .navigation > li:hover > a span.lawyer-messages-count,
        .main-menu .navigation > li.current > a span.lawyer-messages-count {
            color: #DD9B25;
            background-color: #fff !important;
        }

        .main-slider,
        .owl-carousel {
            direction: ltr;
        }

        .auto-container {
            max-width: 1290px;
        }

        .main-menu {
            padding-right: 156px;
        }
        a{
            text-decoration: none;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/fontawesome-stars.css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/bars-square.min.css"
          integrity="sha512-9iUC/Gxz88/M32cMGOzIJKoYqC+UvYECEkaJ+Th6hVX9CJnDZyQ84Ojc+MUa+HD2+2q4RLTJBiY12IJMdwFFog=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/css-stars.min.css"
          integrity="sha512-Epht+5WVzDSqn0LwlaQm6dpiVhajT713iLdBEr3NLbKYsiVB2RiN9kLlrR0orcvaKSbRoZ/qYYsmN1vk/pKSBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    @yield('style')
</head>
