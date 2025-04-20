@forelse($regions as $item)
    @if(isset($lawyer))
        <option value="{{$item->id}}" {{$lawyer->region==$item->id ?'selected':''}}>{{$item->name}} </option>

    @else
        <option value="{{$item->id}}" {{old('region')==$item->id ?'selected':''}}>{{$item->name}} </option>

    @endif
@empty
    <option value="">-- لا يوجد مناطق --</option>
@endforelse
