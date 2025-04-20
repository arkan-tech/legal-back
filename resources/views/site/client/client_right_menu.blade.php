<style>
    .links {
        font-size: 18px;
        font-weight: 500
    }

    a {
        color: #dd9b25;
    }
</style>

<div class="col-lg-2 col-md-12 col-sm-12">
    <div class="row">
        <div style="margin-bottom: 15px;" class="sec-title">
            <a href="{{route('site.client.service-request.index')}}"
               class="links {{(Route::current()->getName() === "site.client.service-request.index") ? "active" : ""}}">
                <i class="fa fa-building"></i>
                <span class="txt">
                    -  طلبـــــــات الخدمـــــــات
                </span>
            </a>
        </div>
    </div>
    <div class="row">
        <div style="margin-bottom: 15px;" class="sec-title">
            <a href="{{route('site.client.advisory-services.index')}}"
               class="links {{(Route::current()->getName() === "site.client.advisory-services.index") ? "active" : ""}}">
                <i class="fa fa-building"></i>
                <span class="txt">
                    -  طلبـــــات الاستشــارات
                </span>
            </a>
        </div>
    </div>
    <div class="row">
        <div style="margin-bottom: 15px;" class="sec-title">
            <a href="{{route('site.digital.guide')}}"
               class="links"
               target="_blank">
                <i class="fa fa-user"></i>
                <span class="txt">
                    -  طلــــــــــــــب مختــــــــــــص
                </span>
            </a>
        </div>
    </div>
    <div class="row">
        <div style="margin-bottom: 15px;" class="sec-title">
            <a href="{{route('site.client.ymtaz-contact.index')}}"
               class="links ">
                <i class="fa fa-envelope-open"></i>
                <span class="txt">
                    - راســــــــــــــــل يمتـــــــــــــــاز
                </span>
            </a>
        </div>
    </div>

    <div class="row">
        <a href="{{route('site.client.profile.edit',auth()->guard('client')->user()->id)}}" class="links">
            <span class="txt">
                <i class="fa fa-cogs"></i>
                - بياناتي الشخصيــــة
            </span>
        </a>
    </div>
    <div class="row mt-4">
        <div style="padding: 0px" class="col-lg-12 col-md-12 col-sm-12">
            <div class="apply-office-sec" style="">
                <a href="{{route('site.client.profile.delete-account')}}" style="padding: 15px 25px;color: #dd9b25" >
                    <i class="fa fa-trash"></i>
                    <span class="txt" style="font-size: 15px">
                 - حــــــذف حــــــســــــابــــــي
                                                 </span>
                </a>
            </div>
        </div>
    </div>
</div>
