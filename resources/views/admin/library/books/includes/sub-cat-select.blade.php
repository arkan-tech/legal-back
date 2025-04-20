
@forelse($sub_cat as $item)
    @if(isset($book))
    <option value="{{$item->id}}" {{$book->CatID == $item->id ?'selected':''}}> {{$item->title}} </option>
    @else
        <option value="{{$item->id}}"> {{$item->title}} </option>

    @endif
@empty
    <option value="">-- لا يوجد اقسم فرعية --</option>
@endforelse
