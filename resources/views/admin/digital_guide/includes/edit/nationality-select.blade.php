@forelse($nationalities as $item)

    @if(isset($lawyer) && !is_null($lawyer->nationality))
        <option value="{{$item->id}}" {{$lawyer->nationality == $item->id ?'selected':''}}>{{$item->name}} </option>
    @else
        <option value="{{$item->id}}">{{$item->name}} </option>
    @endif
@empty
    <option value="">-- لا يوجد جنسيات --</option>
@endforelse
