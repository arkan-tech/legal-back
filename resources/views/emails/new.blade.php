<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,300,400,500,600,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>
        :root {
            --thm-base: #ff0008;
            --thm-base-rgb: 255, 0, 8;
            --thm-primary: #fc454a;
            --thm-primary-rgb: 248, 69, 69;
            --thm-black: #fa4d51;
            --thm-black-rgb: 250, 77, 81;
        }
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #ffffff;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }


    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
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
        .primary{
            background: #448ef6;
        }
        .bg_white{
            background: #ffffff;
        }
        .bg_light{
            background: #fafafa;
        }
        .bg_red{
            background: var(--thm-primary);
        }
        .email-section{
            padding:2.5em;
        }

        /*BUTTON*/
        .btn{
            padding: 8px 18px;
            display: inline-block;
        }
        .btn.btn-primary{
            border-radius: 5px;
            background: #000000;
            color: #ffffff;
        }
        .btn.btn-white{
            border-radius: 30px;
            background: #ffffff;
            color: #000000;
        }
        .btn.btn-white-outline{
            border-radius: 30px;
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        h1,h2,h3,h4,h5,h6{
            font-family: 'Work Sans', sans-serif;
            color: #000000;
            margin-top: 0;
            font-weight: 400;
        }

        body{
            font-family: 'Work Sans', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0,0,0,.4);
        }

        a{
            color: #448ef6;
        }

        table{
        }
        /*LOGO*/

        .logo h1{
            margin: 0;
        }
        .logo h1 a{
            color: #000000;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
        }

        .navigation{
            padding: 0;
        }
        .navigation li{
            list-style: none;
            display: inline-block;;
            margin-left: 5px;
            font-size: 13px;
            font-weight: 500;
        }
        .navigation li a{
            color: rgba(0,0,0,.4);
        }

        /*HERO*/
        .hero{
            position: relative;
            z-index: 0;
        }

        .hero .overlay{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            width: 100%;
            background: #000000;
            z-index: -1;
            opacity: .3;
        }

        .hero .text{
            color: rgba(255,255,255,.9);
        }
        .hero .text h2{
            color: #fff;
            font-size: 50px;
            margin-bottom: 0;
            font-weight: 300;
            line-height: 1;
        }
        .hero .text h2 span{
            font-weight: 600;
            color: #448ef6;
        }


        /*HEADING SECTION*/
        .heading-section{
        }
        .heading-section h2{
            color: #000000;
            font-size: 28px;
            margin-top: 0;
            line-height: 1.4;
            font-weight: 400;
        }
        .heading-section .subheading{
            margin-bottom: 20px !important;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(0,0,0,.4);
            position: relative;
        }
        .heading-section .subheading::after{
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            content: '';
            width: 100%;
            height: 2px;
            background: #448ef6;
            margin: 0 auto;
        }

        .heading-section-white{
            color: rgba(255,255,255,.8);
        }
        .heading-section-white h2{
            /*font-family:*/
            padding-bottom: 0;
        }
        .heading-section-white h2{
            color: #ffffff;
        }
        .heading-section-white .subheading{
            margin-bottom: 0;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,.4);
        }


        /*BLOG*/
        .text-services .meta{
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 0;
        }

        /*FOOTER*/

        .footer{
            color: rgba(255,255,255,.5);

        }
        .footer .heading{
            color: #ffffff;
            font-size: 20px;
        }
        .footer ul{
            margin: 0;
            padding: 0;
        }
        .footer ul li{
            list-style: none;
            margin-bottom: 10px;
        }
        .footer ul li a{
            color: rgba(255,255,255,1);
        }

        .img2{
{{--            background-image:url({{asset('front/assets/images/email/bg_full.png')}});--}}
            background-repeat:no-repeat;
            background-size:contain;
            background-position:center;
        }
        .img3{
            background-image:url({{asset('front/assets/images/email/60.png')}});
            background-repeat:no-repeat;
            background-size:contain;
            background-position:center;
        }



        @media screen and (max-width: 500px) {


        }


    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
<center style="width: 100%; background-color: #ffffff;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;">
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
        <!-- BEGIN BODY -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
            <tr>
                <td valign="middle" class="hero">
                    <div class=""></div>
                    <table>
                        <tr>
                            <td>
                                <img src="{{asset('uploads/person.png')}}" width="130" height="130">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="middle" class="hero" style="">
                    <div class=""></div>
                    <table>
                        <tr>
                            <td>
                                <div class="text" style="padding: 0 4em; text-align: center;">
                                    <br><br><br>
                                    <h3 style="color: #000000;font-size: 25px">مرحبًا بك في  <br>"منصة يمتاز"  </h3>
{{--                                    <p style="color: #fff ;font-size:20px "><h3>{{$details['status']}} </h3> عميلنا العزيز تم تحويل حالة حسابك </p>--}}
                                    <p style="color: #000000 ;font-size:20px "> عميلنا العزيز تم تحويل حالة حسابك الى <h2 style="color: #000000 ;font-size:20px">الحالة الجديدة</h2></p>
                                    <br>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr><!-- end tr -->

            <tr>
                <td valign="middle" class="hero" style="">
                    <div class=""></div>
                    <table>
                        <tr>
                            <td>
                                <div class="text" style=" text-align: center;">
                                    <br><br>
                                    <h3 style="color: #000000"> يمكنك زيارة الرابط التالي  </h3>
{{--                                    <p><a href="{{$details['url']}}" target="_blank" class="btn btn-primary" style="background: #000000;padding: 8px 18px;display: inline-block;  border-radius: 5px;color: #000000fff;"> انقر هنا</a></p>--}}
                                    <p><a href="#" target="_blank" class="btn btn-primary" style="background: #000000;padding: 8px 18px;display: inline-block;  border-radius: 5px;color: #ffffff;"> انقر هنا</a></p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr><!-- end tr -->
            <tr>
                <td valign="middle" class="hero" style="">
                    <div class=""></div>
                    <table>
                        <tr>
                            <td>
                                <div class="text" style="padding: 0 4em; text-align: center;">
                                    <p style="color: #000000"> لا تتردد في الاتصال بنا للحصول على أي دعم أو مساعدة..</p>
                                    <p style="color: #000000">0534337090</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr><!-- end tr -->
            <!-- 1 Column Text + Button : END -->
        </table>
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
            <tr>
                <td valign="middle" class="footer email-section" style="">
                    <table>
                        <tr>
                            <td valign="top" width="33.333%" style="padding-top: 20px;">
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="text-align: left; padding-right: 10px;">
                                            <p class="text" style="margin: 0;color: #000000">تفضلوا بقبول فائق الاحترام,</p>
                                            <h6 class="heading" style="margin: 0;color: #fff">  منصة يمتاز</h6>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr><!-- end: tr -->
            <tr>
                <td valign="middle" class="bg_black">
                    <table>
                        <tr>
                            <td valign="top" width="33.333%">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="text-align: right; padding-right: 10px;color: #000">
                                            <p>&copy; 2021 أكلة هنية. كل الحقوق محفوظة</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>
</center>
</body>
</html>
