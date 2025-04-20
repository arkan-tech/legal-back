@forelse($advisories as $advisory)

    <option
        value="{{$advisory->id}}" {{$advisory->id==$item->advisory_id ?'selected':''}}>{{$advisory->title}} </option>

@empty
    <option value="">-- لا يوجد هيئات --</option>
@endforelse
