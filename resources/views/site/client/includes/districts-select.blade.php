@forelse($districts as $item)
    @if(isset($lawyer))
        <option value="{{$item->id}}" {{$lawyer->district==$item->id ?'selected':''}}>{{$item->title}} </option>
    @else
        <option value="{{$item->id}}" {{old('districts')==$item->id ?'selected':''}}>{{$item->title}} </option>
    @endif
@empty
    <option value="">-- لا يوجد أحياء --</option>
@endforelse
