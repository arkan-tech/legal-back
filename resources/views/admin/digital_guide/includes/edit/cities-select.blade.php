@forelse($cities as $item)

    @if(isset($lawyer) && !is_null($lawyer->city))
        <option value="{{$item->id}}" {{$lawyer->city ==$item->id ?'selected':''}}>{{$item->title}} </option>
    @else
        <option value="{{$item->id}}">{{$item->title}} </option>
    @endif
@empty
    <option value="">-- لا يوجد مدينة --</option>
@endforelse
{{--<option value="0" {{isset($lawyer)?$lawyer->city ==0 ?'selected':'':''}}>أخرى</option>--}}
