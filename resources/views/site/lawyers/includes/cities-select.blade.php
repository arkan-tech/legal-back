@forelse($cities as $item)
    @if(isset($lawyer))
        <option value="{{$item->id}}" {{$lawyer->city==$item->id ?'selected':''}}>{{$item->title}} </option>
    @else
        <option value="{{$item->id}}" {{old('city')==$item->id ?'selected':''}}>{{$item->title}} </option>
    @endif
@empty
    <option value="">-- لا يوجد مدينة --</option>
@endforelse
