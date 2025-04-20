<!DOCTYPE html>
<html>
    <head>
        <!-- <script src="/site/js/jquery.js"></script> -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <!-- Stylesheets -->
        <link href="/site/css/bootstrap.css" rel="stylesheet" />
        <link href="/site/css/style.css" rel="stylesheet" />
        <link href="/site/css/responsive.css" rel="stylesheet" />
        <link href="/site/css/style_ar.css" rel="stylesheet" />
        <!-- Color Switcher Mockup -->
        <link href="/site/css/color-switcher-design.css" rel="stylesheet" />
        <!-- Color Themes -->
        <link id="theme-color-file" href="/site/css/color-themes/default-theme.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet" />
        <link rel="shortcut icon" href="/site/images/logo.png" type="image/x-icon" />
        <link rel="icon" href="/site/images/logo.png" type="image/x-icon" />
        <!-- Responsive -->

        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
        <!--[if lt IE 9]><script src="/site/js/respond.js"></script><![endif]-->

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">




        <style type="text/css">
            .main-menu .navigation > li{
                margin-left: 0px;
            }
            .frgt-pswd{
                padding-top: 15px;
            }
            .frgt-pswd:hover{
                color: #dd9b25;
            }
            .dropdown-item{
                font-family: 'Tajawal Regular' !important;
                text-align: right;
            }
            .select2-container--default .select2-selection--multiple{
                border: 1px solid #f4f4f4;
                border-radius: 0px;
                height: 50px
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice{
                float: right;
            }
            .select2-container--default .select2-search--inline .select2-search__field, .select2-results__option[aria-selected]{
                text-align: right
            }
            .main-menu .navigation > li > a{
                padding: 20px 11px;
            }
            .content-box p{
                color: #fff !important;
            }
            .close{
                float: left !important;
            }
            .messages-count{
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
            .main-menu .navigation > li.current > a span.messages-count{
                color:#DD9B25;
                background-color: #fff !important;
            }


            .lawyer-messages-count{
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
            .main-menu .navigation > li.current > a span.lawyer-messages-count{
                color:#DD9B25;
                background-color: #fff !important;
            }
            .main-slider, .owl-carousel{
                direction: ltr;
            }

            .auto-container{
                max-width: 1290px;
            }

            .main-menu {
                padding-right: 156px;
            }

           /* body{
                direction: rtl
            }*/
        </style>




<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js"></script>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/fontawesome-stars.css">

<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/bars-square.min.css" integrity="sha512-9iUC/Gxz88/M32cMGOzIJKoYqC+UvYECEkaJ+Th6hVX9CJnDZyQ84Ojc+MUa+HD2+2q4RLTJBiY12IJMdwFFog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/css-stars.min.css" integrity="sha512-Epht+5WVzDSqn0LwlaQm6dpiVhajT713iLdBEr3NLbKYsiVB2RiN9kLlrR0orcvaKSbRoZ/qYYsmN1vk/pKSBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">-->

    </head>
    <body lang="en" dir="rtl">
        <?
//$Social=json_decode(AllSettings()->social); ?> @include('sweetalert::alert')
        <div class="page-wrapper">

            <!-- Sidebar Cart Item -->
            <div class="xs-sidebar-group info-group">
                <div class="xs-overlay xs-bg-black"></div>
                <div class="xs-sidebar-widget">
                    <div class="sidebar-widget-container">
                        <div class="widget-heading">
                            <a href="#" class="close-side-widget">
                                X
                            </a>
                        </div>
                        <div class="sidebar-textwidget">
                            <!-- Sidebar Info Content -->
                            <div class="sidebar-info-contents">
                                <div class="content-inner">
                                    <div class="logo">
                                        <a href="/"><img src="/site/images/logo.png" alt="" /></a>
                                    </div>
                                    <div class="content-box">
                                        <h2>من نحن</h2>
                                        <p class="text"><?=aboutdetails()->details;?></p>

                                        @if(Session::get('loggedInUserID') != '')
                                            <a class="theme-btn btn-style-two" href="/logout"><span class="txt"> تسجيل الخروج </span></a>
                                        @elseif(Session::get('loggedInClientID') != '')
                                            <a class="theme-btn btn-style-two" href="/client-logout"><span class="txt"> تسجيل الخروج </span></a>

                                        @endif

                                    </div>
                                    <div class="contact-info">
                                        <h2>معلومات التواصل</h2>
                                        <ul class="list-style-two">
                                            <li>
                                                <span class="icon fa fa-location-arrow"></span>
                                                <?=setting('site.address');?>
                                            </li>
                                            <li>
                                                <span class="icon fa fa-phone"></span>
                                                <?=setting('site.phone1');?>
                                            </li>
                                            <li>
                                                <span class="icon fa fa-envelope"></span>
                                                <?=setting('site.phone2');?>
                                            </li>
                                            <li>
                                                <span class="icon fa fa-clock-o"></span>
                                                <?=setting('site.working.hours');?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END sidebar widget item -->

            @yield('content')

        </div>
        <!--End pagewrapper-->

        <!-- Scroll To Top -->
        <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>

        <!-- Header Search -->
        <div class="search-popup">
            <button class="close-search style-two"><span class="flaticon-multiply"></span></button>
            <button class="close-search"><span class="flaticon-multiply"></span></button>
            <form method="post" action="blog.html">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="بحث" required="" />
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <!-- End Header Search -->


        <script src="/site/js/popper.min.js"></script>
        <script src="/site/js/bootstrap.min.js"></script>
        <script src="/site/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="/site/js/jquery.fancybox.js"></script>
        <script src="/site/js/appear.js"></script>
        <script src="/site/js/nav-tool.js"></script>
        <script src="/site/js/mixitup.js"></script>
        <script src="/site/js/owl.js"></script>
        <script src="/site/js/wow.js"></script>
        <script src="/site/js/isotope.js"></script>
        <script src="/site/js/jquery-ui.js"></script>
        <script src="/site/js/script.js"></script>
        <script src="/site/js/color-settings.js"></script>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

        <script>
            $('#sections').select2({ width: '100%', placeholder: "التخصصات", allowClear: true });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".reservation-submit").click(function(e){
                    e.preventDefault();

                    var _token = $("input[name='_token']").val();
                    var email = $("#email").val();
                    var name = $("#name").val();
                    var reservation_message = $('#reservation_message').val();
                    var case_type = $('#case_type').val();

                    $.ajax({
                        url: "{{ route('ajax.request.store') }}",
                        type:'POST',
                        data: { _token:_token, email:email, name: name, case_type: case_type, reservation_message: reservation_message },
                        success: function(data) {

                            $("#reservations")[0].reset();
                            printMsg(data);
                        }
                    });
                });

                function printMsg (msg) {
                    if($.isEmptyObject(msg.error))
                    {
                        $('.text-danger').hide();
                        console.log(msg.success);
                        $('.alert-block').css('display','block').append('<strong>'+msg.success+'</strong>').delay(2000).fadeOut();;
                    }else{
                        $.each( msg.error, function( key, value ) {
                            $('.'+key+'_err').text(value);
                        });
                    }
                }
            });
        </script>


        <script src="/site/js/jquery-repeater/jquery.repeater.js"></script>
        <script src="/site/js/jquery-repeater/form-repeater.min.js"></script>

    </body>
</html>
