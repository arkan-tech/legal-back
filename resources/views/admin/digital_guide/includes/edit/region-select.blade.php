<option value="">اختر</option>

@forelse($regions as $item)

    @if(isset($lawyer) && !is_null($lawyer->region))
        <option value="{{$item->id}}" {{ $lawyer->region===$item->id ?'selected':''}}>{{$item->name}} </option>
    @else
        <option value="{{$item->id}}">{{$item->name}} </option>
    @endif

@empty
    <option value="">-- لا يوجد مناطق --</option>
@endforelse
