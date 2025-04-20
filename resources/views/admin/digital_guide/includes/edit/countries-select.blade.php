@forelse($countries as $item)

    @if(isset($lawyer) && !is_null($lawyer->country_id))
        <option value="{{$item->id}}" {{$lawyer->country_id ==$item->id ?'selected':''}}>{{$item->name}} </option>
    @else
        <option value="{{$item->id}}">{{$item->name}} </option>
    @endif
@empty
    <option value="">-- لا يوجد دولة --</option>
@endforelse
