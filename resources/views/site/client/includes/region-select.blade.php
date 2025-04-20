@forelse($regions as $item)
    @if(isset($client))
        <option value="{{$item->id}}" {{$client->region_id==$item->id ?'selected':''}}>{{$item->name}} </option>

    @else
        <option value="{{$item->id}}" {{old('region')==$item->id ?'selected':''}}>{{$item->name}} </option>

    @endif
@empty
    <option value="">-- لا يوجد مناطق --</option>
@endforelse
