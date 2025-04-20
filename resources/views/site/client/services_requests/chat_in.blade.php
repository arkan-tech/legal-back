<li class="out">
    <img class="avatar" src="{{asset('uploads/person.png')}}">
    <div id="" class="message" style="background-color:#dff0d8">
        <span class="arrow"></span>
        <div class="row" style="margin: 0px;">

            <div class="col-lg-12" style="padding-left: 0px;">

                        <span class="pull-right" style="font-size: 10pt;">
                            {{GetArabicDate2($reply->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($reply->created_at)))}}
                        </span>
                <span class="name"> {{auth()->guard('client')->user()->myname }} </span>
            </div>
        </div>
        <div class="clearfix"></div>
        <span class="body">
                @if(!is_null($reply->file))
                <img src="{{$reply->file}}">
            @endif
            {{ $reply->replay }}
                </span>
    </div>
</li>
<div class="clearfix"></div>
