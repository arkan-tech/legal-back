<!-- Main Footer -->
<footer class="main-footer style-three" style="background-image: url('{{asset('site/images/background/3.jpg')}}');">
    <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
            <div class="row clearfix">
                <!-- Footer Column -->
                <div class="footer-column col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget logo-widget">
                        <div class="logo">
                            <a href="/"><img src={{asset('site/images/logo.png')}} alt=""/></a>
                        </div>
                        <div class="text">
                            <p></p>
                        </div>
                    </div>
                </div>

                <!-- Footer Column -->
                <div class="footer-column col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget news-widget">
                        <h4> نافذة التدريب </h4>
                        <!-- Footer Column -->
                        <div class="widget-content"></div>
                    </div>
                </div>

                <!-- Footer Column -->
                <div class="footer-column col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget contact-widget">
                        <h4>اتصل الآن</h4>
                        <ul class="contact-list">
                            <li>
                                <span class="icon flaticon-email-5"></span>
                                {{setting('site.email')}}

                                <strong>البريد الالكتروني</strong>
                            </li>
                            <li>
                                <span class="icon flaticon-location"></span>
                                {{setting('site.address')}}
                                <strong>العنوان</strong>
                            </li>
                            <li>
                                <span class="icon flaticon-alarm-clock"></span>
                                {{setting('site.working.hours') }}
                                <strong>ساعات العمل</strong>
                            </li>
                            <li>
                                <span class="icon flaticon-telephone-1"></span>
                                {{setting('site.phone1')}}

                                <strong>  اطلب المساعدة</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="auto-container">
            <div class="row clearfix">
                <!-- Column -->
                <div class="column col-lg-6 col-md-12 col-sm-12">
                    <div class="copyright">&copy; 2021 جميع الحقوق محفوظة</div>
                </div>
                <!-- Column -->
                <div class="column col-lg-6 col-md-12 col-sm-12">
                    <!-- Social Nav -->
                    <ul class="social-nav">
                        <li>
                            <a><span class="fa fa-google-plus"></span></a>
                        </li>
                        <li>
                            <a><span class="fa fa-twitter"></span></a>
                        </li>
                        <li>
                            <a><span class="fa fa-youtube"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
