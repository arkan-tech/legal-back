@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top"
         style=" background-image: url('{{asset('site/electronic_office/images/header-img.png')}}'); background-color:white;: ">
        @include('site.lawyers.electronic_office.layouts.menue',['electronic_id_code'=>$id])

        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 50%">
                <h3><b>خدمات قانونية مختلفة</b></h3>
                <p style="color: #fff">نوفر من خلال مجموعة ماجد بن طالب مجموعة مختلفة من الخدمات
                    <br>القانونية التى تحتاج اليها</p>
            </div>
        </div>


    </div>
    <!---end header-->
@endsection

@section('electronic_office_content')

    <!--about--->
    <section id="about">
        <div class="text-center logo-about">
            <img src="{{asset('site/electronic_office/images/logo-icon.png')}}"/>
            <h4><b>مــن نحـــن</b></h4>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-right about-right">
                        <h4>مجموعــــة ماجـــد بـــن طـــــالب
                            <br>
                            <br>للمحاماة والاستشارات القانونية
                        </h4>
                        <p>لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم
                            في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس
                            عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب
                            بمثابة دليل أو مرجع شكلي.</p></div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div>
                        <img src="{{asset('site/electronic_office/images/about-image.png')}}" height="100%">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--end about-->


    <!--services-->
    <section id="services">


        <div class="container">
            <h4 class="service-office"><b>خدمات المكتب</b></h4>


            <div class="row">
                <div class="col-md-4">
                    <div class="right-content-service">
                        <div class="header-content">
                            <p><img src="{{asset('site/electronic_office/images/icon1.png')}}"/>النيابة العامة</p>
                        </div>
                        <div class="desc">

                            <p><img src="{{asset('site/electronic_office/images/icon3.png')}}"/> يحق لكل متهم ان يستعين
                                بوكيل او محام للدفاع عنه فى مرحلتى
                                التحقيق والمحاكمة.</p>

                            <p><img src="{{asset('site/electronic_office/images/icon3.png')}}"/>يحق لكل متهم ان يستعين
                                بوكيل او محام للدفاع عنه فى مرحلتى
                                التحقيق والمحاكمة.</p>

                        </div>

                    </div>

                    <div class="right-content-service">
                        <div class="header-content">
                            <p><img src="{{asset('site/electronic_office/images/icon4.png')}}"/>وزارة العمل والتنمية
                                االجتماعية</p>
                        </div>
                        <div class="desc">

                            <p><img src="{{asset('site/electronic_office/images/icon3.png')}}"/>اذا انتهت خدمة العامل
                                وجب على صاحب العمل تصفية حقوقة خلال
                                اسبوع على الاكثر من تاريخ انتهاء العلاقة التعاقدية.</p>


                        </div>

                    </div>


                    <div class="right-content-service">
                        <div class="header-content">
                            <p><img src="{{asset('site/electronic_office/images/icon4.png')}}"/>وزارة الصحة</p>
                        </div>
                        <div class="desc">

                            <p><img src="{{asset('site/electronic_office/images/icon3.png')}}"/>اذا انتهت خدمة العامل
                                وجب على صاحب العمل تصفية حقوقة
                                خلالهذا النص يمكن استبداله بنص أخر هذا النص يمكن استبداله بنصت أخر هذا النص يمكن
                                استبداله بنص أخر هذا النص يمكن استبداله بنــص أخر هذا النص يمكن استبداله بنص أخر .</p>


                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-img">
                        <img src="{{asset('site/images/logo.png')}}" height="100%" width="100%"/>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="right-content-service">
                        <div class="header-content">
                            <p><img src="{{asset('site/electronic_office/images/icon2.png')}}"/>المرور</p>
                        </div>
                        <div class="desc">

                            <p><img src="{{asset('site/electronic_office/images/icon3.png')}}"/>اذا انتهت خدمة العامل
                                وجب على صاحب العمل تصفية حقوقةشركات
                                التأمين ملزمة بتغطية المسؤولية المدنية الكامية النائة عن الوفاة أو الاصابة البندنية او
                                الاضرار المادية الناتجة عن الحوادث المرورية اذا كاان سائق المركبة لدية وثيقة تأمين سارية
                                المفعول ويحمل رخصة قياده او تصريحاً يؤهلة لقيادة المركبة مهما كانت الاسباب وللشركة حق
                                الرجوع الى المؤمن له بالطرق النظامية فى حالة مخالته لعقد التأمين.</p>


                        </div>

                    </div>

                    <div class="right-content-service">
                        <div class="header-content">
                            <p><img src="{{asset('site/electronic_office/images/icon1.png')}}"/>وزارة التجارة</p>
                        </div>
                        <div class="desc">

                            <p><img src="{{asset('site/electronic_office/images/icon3.png')}}"/>هذا النص يمكن استبداله
                                بنص أخر هذا النص يمكن استبداله بنصت
                                أخر هذا النص يمكن استبداله بنص أخر هذا النص يمكن استبداله بنــص أخر هذا النص يمكن
                                استبداله بنص أخر .</p>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--end services-->
@endsection
