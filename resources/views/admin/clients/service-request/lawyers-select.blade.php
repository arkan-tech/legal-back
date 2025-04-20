@forelse($lawyers as $lawyer)

    <option
        value="{{$lawyer->id}}" {{$item->lawyer_id == $lawyer->id ?'selected':''}}>{{$lawyer->name}} </option>
@empty
    <option value="">-- لا يوجد مستشارين --</option>
@endforelse
