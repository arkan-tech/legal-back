@forelse($items as $item)

    <option value="{{$item->id}}">{{$item->name}} </option>
@empty
    <option value="">-- لا يوجد فروع--</option>
@endforelse
