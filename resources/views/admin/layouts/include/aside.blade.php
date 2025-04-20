<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href=""><span class="brand-logo">
                        <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%"
                                    y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%"
                                    y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path"
                                            d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                            style="fill:currentColor"></path>
                                        <path id="Path1"
                                            d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                            fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                            points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                        </polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                            points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                        </polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994"
                                            points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    <h2 class="brand-text">Ymtaz</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('admin.home') }}">
                    <i data-feather="circle"></i><span class="menu-title text-truncate" data-i18n="Email">لوحة
                        التحكم</span></a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> المواعيد والحجوزات </span>
                </a>
                <ul class="menu-content">

                    <li>
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.advisory_services_importance.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> درجات الاهمية للحجوزات</span></a>
                    </li>

                    <li>
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.client_reservations_types.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> انواع المواعيد</span>
                        </a>
                    </li>

                    <li>
                        <a class="d-flex align-items-center" href="{{ route('admin.client_reservations.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> مواعيد العملاء الخاصة</span>
                        </a>
                    </li>

                    <li>
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.client_ymtaz_reservations.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> مواعيد يمتاز</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.clients.lawyer-reservation.index') }}">
                            <i data-feather="circle"></i>
                            <span class="" data-i18n="List"> مواعيد مع مقدمي الخدمة</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> نافذة الاستشارات </span>
                </a>
                <ul class="menu-content">
                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.advisory_services_base.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> فئات الاستشارات</span></a>
                    </li>
                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.advisory_services.payment_categories.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> باقات الاستشارات</span></a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.advisory_services.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> وسائل الاستشارات</span></a>
                    </li>


                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.advisory_services_types.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> انواع الاستشارات</span></a>
                    </li>

                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="List">وارد طلبات الاستشارات
                    </span>
                </a>
                <ul class="menu-content">
                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.client_advisory_services_reservations.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> طلبات العملاء </span>
                        </a>
                    </li>
                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="#">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> طلبات مقدمي الخدمة</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> إدارة طلبات الخدمات </span>
                </a>
                <ul class="menu-content">
                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.services.categories.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> الاقسام الرئيسية </span>
                        </a>
                    </li>
                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.services.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> مسميات الخدمات </span>
                        </a>
                    </li>


                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> وارد طلبات الخدمات </span>
                </a>
                <ul class="menu-content">

                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.clients.service-request.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> طلبات خدمات العملاء </span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.organization-requests.index') }}">
                            <i data-feather="circle"></i>
                            <span class="" data-i18n="Email"> طلبات مقدمي الخدمة</span></a>
                    </li>

                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.request_levels.index') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> مستويات الطلبات </span>
                </a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.digital-guide.index') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> الدليل الرقمي </span>
                </a>
            </li>

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.clients.index') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> قائمة العملاء </span>
                </a>
            </li>

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> اعدادات طالبي الخدمة </span>
                </a>

                <ul class="menu-content">


                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.clients.ymtaz-contacts.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> رسائل العملاء </span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.complains.index') }}">
                            <i data-feather="circle"></i>
                            <span class="" data-i18n="List"> شكاوى العملاء</span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.clients.delete-accounts-requests.index') }}">
                            <i data-feather="circle"></i>
                            <span class="" data-i18n="List"> طلبات حذف الحسابات</span>
                        </a>
                    </li>


                </ul>
            </li>

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> اعدادات مقدمي الخدمة </span>
                </a>
                <ul class="menu-content">

                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.digital-guide.delete-accounts.index') }}">
                            <i data-feather="circle"></i>
                            <span class="" data-i18n="List"> طلبات حذف الحسابات</span>
                        </a>
                    </li>
                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.digital-guide.sections.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> قائمة المهن </span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.general_specialty.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> التخصصات العامة </span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.accurate_specialty.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> التخصصات الدقيقة </span></a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.lawyer_types.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">صفات مقدمي الخدمة </span></a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.functional_cases.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> الحالات الوظيفية</span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.countries.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">قائمة الدول</span></a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.nationalities.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">قائمة الجنسيات</span></a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.regions.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">قائمة المناطق </span></a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.cities.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">قائمة المدن </span></a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.districts.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List">قائمة الاحياء </span></a>
                    </li>


                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> هيئة المستشارين </span>
                </a>
                <ul class="menu-content">

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.advisory-committees.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> الهيئات </span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.advisory-committees.members.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> الاعضاء </span>
                        </a>
                    </li>



                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> المكتبة </span>
                </a>
                <ul class="menu-content">

                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.library.category.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> الاقسام </span>
                        </a>
                    </li>


                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('admin.library.books.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> الكتب </span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.library.rules_regulations.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> دليل الأنظمة السعودية</span>
                        </a>
                    </li>

                    <li class=" nav-item">
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.library.judicial_blogs.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="Email"> المدونات القضائية </span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.training.index') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> نافذة التدريب</span>
                </a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> القناة الثقافية</span></a>
            </li>


            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> الدليل العدلي </span>
                </a>
            </li>




            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.digital-guide.packages.index') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice"> الباقات </span>
                </a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> الفواتير </span>
                </a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.contact.index') }}">
                    <i data-feather="circle"></i>
                    <span class="menu-title text-truncate" data-i18n="Email"> رسائل تواصل معنا </span>
                </a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.ymtaz-contacts.index') }}">
                    <i data-feather="circle"></i>
                    <span class="" data-i18n="Email">رسائل مقدمي الخدمة </span></a>
            </li>
            <li
                class=" nav-item {{ in_array(Route::current()->getName(), ['admin.settings.terms-conditions', 'admin.districts.index', 'admin.countries.index', 'admin.cities.index']) ? 'has-sub open' : '' }}">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="settings"></i>
                    <span class="menu-title text-truncate" data-i18n="Invoice">اعدادات </span>
                </a>
                <ul class="menu-content">

                    <li {{ Route::current()->getName() === 'admin.settings.terms-conditions' ? 'active' : '' }}>
                        <a class="d-flex align-items-center" href="{{ route('admin.settings.terms-conditions') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item " data-i18n="List"> بنود وميثاق المحامين</span></a>
                    </li>

                    <li {{ Route::current()->getName() === 'admin.settings.client.terms-conditions' ? 'active' : '' }}>
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.settings.client.terms-conditions') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item " data-i18n="List"> بنود وميثاق العملاء</span></a>
                    </li>

                    <li {{ Route::current()->getName() === 'admin.settings.site-information.index' ? 'active' : '' }}>
                        <a class="d-flex align-items-center"
                            href="{{ route('admin.settings.site-information.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="List"> اعدادات يمتاز</span></a>
                    </li>

                    <li>
                        <a class="d-flex align-items-center" href="{{ route('admin.splash.index') }}">
                            <i data-feather="circle"></i>
                            <span class="" data-i18n="List"> صور مقدمة التطبيق</span>
                        </a>
                    </li>

                    <li>
                        <a class="d-flex align-items-center" href="{{ route('admin.benefit.index') }}">
                            <i data-feather="circle"></i>
                            <span class="" data-i18n="List"> فائدة اليوم</span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
