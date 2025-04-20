@forelse($nationalities as $item)

    @if(isset($client))
        <option value="{{$item->id}}" {{$client->nationality_id == $item->id ?'selected':''}}>{{$item->name}} </option>
    @else
        <option value="{{$item->id}}">{{$item->name}} </option>
    @endif
@empty
    <option value="">-- لا يوجد جنسيات --</option>
@endforelse
