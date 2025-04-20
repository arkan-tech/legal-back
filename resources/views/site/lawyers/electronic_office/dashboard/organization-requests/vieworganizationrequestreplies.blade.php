<li class="out">
    <img class="avatar" src="{{asset('/uploads/person.png')}}">
    <div id="" class="message" style="background-color:#dff0d8">
        <span class="arrow"></span>
        <div class="row" style="margin: 0px;">

            <div class="col-lg-12" style="padding-left: 0px;">

                <span class="pull-right" style="font-size: 10pt;">
                    {{GetArabicDate2($consultation->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($consultation->created_at)))}}
                </span>
                <span class="name"> {{ $consultation->lawyer->name }} </span>
            </div>
        </div>
        <div class="clearfix"></div>
        <span class="body">
            {{ $consultation->description }}
        </span>
    </div>
</li>

<div class="clearfix"></div>


@foreach($replies as $reply)
    @if($reply->from == 2)
        <li class="in">
            <img class="avatar" src="{{asset('uploads/person.png')}}" alt="" />
            <div class="message">
                <span class="arrow"></span>
                <span class="name"> يمتاز </span>
                <span class="pull-left" style="font-size: 10pt;">
                    {{GetArabicDate2($reply->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($reply->created_at)))}}
                </span>

                <div class="clearfix"></div>
                <span class="body">
                    {{ $reply->reply }}
                </span>
            </div>
        </li>
        <div class="clearfix"></div>
    @else
        <li class="out">
            <img class="avatar" src="{{asset('uploads/person.png')}}" >
            <div id="" class="message" style="background-color:#dff0d8">
                <span class="arrow"></span>
                <div class="row" style="margin: 0px;">

                    <div class="col-lg-12" style="padding-left: 0px;">

                        <span class="pull-right" style="font-size: 10pt;">
                            {{GetArabicDate2($reply->created_at) . ' - ' . GetPmAmArabic(date('h:i A', strtotime($reply->created_at)))}}
                        </span>
                        <span class="name"> {{ $reply->lawyer->name }} </span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <span class="body">
                    {{ $reply->reply }}
                </span>
            </div>
        </li>
        <div class="clearfix"></div>
    @endif

@endforeach

