<div class="col-lg-2 col-md-12 col-sm-12">

    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   class=" "
                   href="{{route('site.lawyer.profile.info')}}">
                    <i class="fa fa-user"></i>

                    <span class="txt" style="font-size: 15px">
                                                       نــــــــــــافــــــذة الدلــــــــــــيــــــل
                                                 </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row mt-4 ">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            @if($lawyer->paid_status != 1)
                <div class="apply-office-sec" style="">

                    <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                       class=" "
                       href="{{route('site.lawyer.showPaymentRules')}}">
                        <i class="fa fa-user"></i>
                        <span class="txt" style="font-size: 15px">
                                                      بـــاقـــات الدلـــيل الرقـــمي
                                                 </span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   class=" "
                   href="{{route('site.lawyer.services.prices.index')}}">
                    <i class="fa fa-dollar"></i>

                    <span class="txt" style="font-size: 15px">
                                                      اســــــــــــعــــــار خدمــــــــاتــــــى
                                                 </span>
                </a>
            </div>
        </div>
    </div>

{{--    <div class="row mt-4">--}}
{{--        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">--}}
{{--            <div class="apply-office-sec" style="">--}}

{{--                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"--}}
{{--                   class=" "--}}
{{--                   href="{{route('site.lawyer.services-requests',$lawyer->id)}}">--}}
{{--                    <i class="fa fa-user"></i>--}}
{{--                    <span class="txt" style="font-size: 15px">--}}
{{--                                                      طلبـــــــــــــــــــات الخدمــــــات--}}
{{--                                                 </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   class=""
                   href="{{route('site.lawyer.organization-requests.index')}}">
                    <i class="fa fa-briefcase"></i>
                    <span class="txt" style="font-size: 15px">
                                                      طلب  استـــــــــــــــــــــــشارية
                                                 </span>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   class=" "
                   href="{{route('site.lawyer.client_advisory_services_reservations.index')}}">
                    <i class="fa fa-paper-plane"></i>
                    <span class="txt" style="font-size: 15px">
                                                    اســتشارات مُحـــالة لك
                                                 </span>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   class=" "
                   href="{{route('site.lawyer.clients-service-requests.index')}}">
                    <i class="fa fa-paper-plane"></i>
                    <span class="txt" style="font-size: 15px">
                                                    طلبـــــــــــــــــــات الخدمــــــات
{{--                                                    طلبـــــــــــــات مُحـــــــــالة لك--}}
                                                 </span>
                </a>
            </div>
        </div>
    </div>


{{--    <div class="row mt-4">--}}
{{--        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">--}}
{{--            <div class="apply-office-sec" style="">--}}

{{--                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"--}}
{{--                   class=" "--}}
{{--                   href="">--}}
{{--                    <i class="fa fa-heart"></i>--}}
{{--                    <span class="txt" style="font-size: 15px">--}}
{{--                                                   المــــــفـــــــــــــــــــضـــــــــــــــــلــــــة--}}
{{--                                                 </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   class=" "
                   href="{{route('site.lawyer.contact-ymtaz.index')}}">
                    <i class="fa fa-reply"></i>
                    <span class="txt" style="font-size: 15px">
                                                   راســـــــــــــــــــــــــــــل يمــــــتــــــاز
                                                 </span>
                </a>
            </div>
        </div>
    </div>

{{--    <div class="row mt-4">--}}
{{--        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">--}}
{{--            <div class="apply-office-sec" style="">--}}

{{--                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"--}}
{{--                   class=" "--}}
{{--                   href="">--}}
{{--                    <i class="fa-solid fa-graduation-cap"></i>--}}
{{--                    <span class="txt" style="font-size: 15px">--}}
{{--                                                  دوراتـــــــــــــــــــــــــــــــــــــــــــــــــــــي--}}
{{--                                                 </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   class=" " target="_blank"
                   href="{{route('site.lawyer.profile.edit',auth()->guard('lawyer')->user()->id)}}">
                    <i class="fa fa-cogs"></i>
                    <span class="txt" style="font-size: 15px">
                                                           تحديث البــــــيــــــانــــــات
                                                 </span>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">

                <a style="padding: 15px 25px;color: #dd9b25" data-id="{{ $lawyer->id }}"
                   href="{{route('site.lawyer.profile.delete-account')}}">
                    <i class="fa fa-trash"></i>
                    <span class="txt" style="font-size: 15px">
                 - حــــــذف حــــــســــــابــــــي
                                                 </span>
                </a>
            </div>
        </div>
    </div>

</div>
