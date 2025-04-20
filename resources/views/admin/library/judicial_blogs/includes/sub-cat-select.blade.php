@forelse($sub_cat as $cat)
    @if(isset($item))
        <option value="{{$cat->id}}" {{$item->sub_category_id == $cat->id ?'selected':''}}> {{$cat->title}} </option>
    @else
        <option value="{{$cat->id}}"> {{$cat->title}} </option>
    @endif
@empty
    <option value="">-- لا يوجد اقسم فرعية --</option>
@endforelse
