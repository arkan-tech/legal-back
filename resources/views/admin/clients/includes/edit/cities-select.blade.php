@forelse($cities as $item)

    @if(isset($client) )
        <option value="{{$item->id}}" {{$client->city_id == $item->id ?'selected':''}}>{{$item->title}} </option>
    @else
        <option value="{{$item->id}}">{{$item->title}} </option>
    @endif
@empty
    <option value="">-- لا يوجد مدينة --</option>
@endforelse
