<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <title>المكتب الالكتروني</title>
    <link rel="stylesheet" href="{{asset('site/electronic_office/css/assets/css/docs.theme.min.css')}}">

    <!-- Owl Stylesheets -->
    <link rel="stylesheet"
          href="{{asset('site/electronic_office/css/assets/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('site/electronic_office/css/assets/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('site/electronic_office/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/electronic_office/css/index_style.css')}}"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
          integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('site/css/flaticon.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('site/css/style_ar.css')}}"/>
    <style>
        .avatar {
            width: 50px;
            border-radius: 50%;
        }
        .chats{
            width: 100%;
        }
        .chats li {
            list-style: none;
            padding: 8px 0 5px;
            margin: 7px auto;
            font-size: 15px;
            width: 50%
        }
        .chats li.in {
            float: right
        }
        .chats li.out {
            float: left
        }
        .chats li .message .body {
            display: block;
        }
        .chats li .message {
            display: block;
            padding: 5px;
            position: relative;

            background: #fbfbfb;
            background-color: rgb(251, 251, 251);
            border-left: 1px solid #eaeaea !important;
            border-right: 1px solid #eaeaea !important;
            padding: 10px !important;
            border-radius: 5px;
        }
        .chats li.in .message {
            text-align: right;
            margin-right: 65px;
            width: 100%
        }
        li.in .message .arrow {
            border-bottom: 8px solid transparent;
            border-top: 8px solid transparent;
            display: block;
            height: 0;
            right: -8px;
            position: absolute;
            top: 15px;
            width: 0;
        }

        .chats li.in .message .arrow {
            border-right: 8px solid #2f8e95;
        }
        li.in .name {
            color: #FB9800 !important;
        }
        .chats li .name {
            font-size: 16px;
            font-weight: 700;
        }
        .chats li.in img.avatar {
            float: right;
            margin-left: 10px;
            height: 45px;
            width: 45px;
        }

        .chats li.out img.avatar {
            float: left;
            margin-right: 10px;
            margin-top: 0px;
            height: 45px;
            width: 45px;
        }
        .chats li.out .name {
            color: #2FADE7 !important;
        }
        .chats li.out .message {
            border-left: 2px solid #b14c4c;
            margin-left: 65px;
            text-align: left;

            /* min-height: 130px; */
            background-color: #dff0d8;
        }

        .chats li.out .message .arrow {
            border-right: 8px solid #2f8e95;
        }

        li.out .message .arrow {
            border-bottom: 8px solid transparent;
            border-top: 8px solid transparent;
            display: block;
            height: 0;
            left: -10px;
            position: absolute;
            top: 15px;
            width: 0;
        }

        .message {
            border: 1px solid #eaeaea;
        }
    </style>
</head>
