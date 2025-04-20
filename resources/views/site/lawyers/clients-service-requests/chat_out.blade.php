
<li class="in">
    <img class="avatar" src="{{asset('uploads/person.png')}}"
         alt=""/>
    <div class="message">
        <span class="arrow"></span>
        <span class="name"> {{auth()->guard('lawyer')->user()->name}} </span>

        <span class="pull-left" style="font-size: 10pt;">
                    {{GetArabicDate2($reply->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($reply->created_at)))}}
                </span>

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
