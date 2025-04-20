@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            {{--            @include('admin.layouts.alerts.errors')--}}
            <div class="content-body">
                <div class="row">
                    <div class="col-12">

                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.library.books.update')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> تعديل الكتاب </h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <input type="hidden" name="id" value="{{$book->id}}">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">اسم الكتاب </label>
                                            <input type="text"
                                                   class="form-control @error('Title')is-invalid @enderror"
                                                   name="Title" value="{{$book->Title}}"/>
                                            @error('Title')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">سعر الكتاب </label>
                                            <input type="number" min="0"
                                                   class="form-control @error('price')is-invalid @enderror"
                                                   name="price"  value="{{$book->price}}"/>
                                            @error('price')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="author"> المؤلف </label>
                                            <input type="text"
                                                   class="form-control @error('author')is-invalid @enderror"
                                                   name="author"  value="{{$book->author}}"/>
                                            @error('author')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>


                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الكتاب النسخة
                                                الانجليزية </label>
                                            <input type="file"
                                                   class="form-control @error('link_en')is-invalid @enderror"
                                                   name="link_en" accept=".pdf"/>
                                            @error('link_en')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                            <div class="col-12 col-sm-6 mb-1">
                                                <a href="{{$book->link_en}}" target="_blank" class="btn btn-primary mt-1">
                                                    افتح الكتاب
                                                </a>
                                            </div>
                                        </div>


                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الكتاب النسخة
                                                العربي</label>
                                            <input type="file"
                                                   class="form-control @error('Link')is-invalid @enderror"
                                                   name="Link" accept=".pdf"/>

                                            @error('Link')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                            <div class="col-12 col-sm-6 mb-1">
                                                <a href="{{$book->Link}}" target="_blank" class="btn btn-primary mt-1">
                                                    افتح الكتاب
                                                </a>
                                            </div>

                                        </div>


                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName">صورة تعبيرية
                                                للكتاب </label>
                                            <input type="file"
                                                   class="form-control @error('Image')is-invalid @enderror"
                                                   name="Image" accept=".png,.jpg,.jpeg"/>

                                            @error('Image')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                            <img class="mt-2 avatar-border" src="{{$book->Image}}"
                                                 width="90px"
                                                 height="50%" alt="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> القسم الرئيسي </label>
                                            <select id="main_cat"
                                                    class="form-control select2 @error('main_cat')is-invalid @enderror"
                                                    name="main_cat" required>
                                                <option value=""> اختر قسم رئيسي</option>

                                                @foreach($main_cat as $cat)
                                                    <option
                                                        value="{{$cat->id}}" {{$m_cat->id == $cat->id ?'selected':''}}> {{$cat->title}} </option>
                                                @endforeach
                                            </select>
                                            @error('main_cat')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> القسم الفرعي </label>
                                            <select id="sub_cat_select"
                                                    class="form-control select2 @error('sub_cat')is-invalid @enderror"
                                                    name="sub_cat" required>
                                                @include('admin.library.books.includes.sub-cat-select')
                                            </select>
                                            @error('sub_cat')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountFirstName"> تفاصيل </label>
                                            <textarea name="details"
                                                      class="form-control @error('details')is-invalid @enderror"
                                                      cols="30" rows="5">{{$book->details}}</textarea>
                                            @error('details')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ
                                </button>
                                <a href="{{route('admin.library.books.index')}}" type="reset"
                                   class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </a>
                            </div>
                        </form>
                        <!--/ form -->


                    </div>

                </div>


            </div>
        </div>
    </div>

    <!-- END: Content-->
@endsection
@section('scripts')

    <script>
        $('#main_cat').on('change', function () {
            let value = $(this).val();
            let actionUrl = '{{route('admin.library.books.get-library-sub-cat-base-id')}}' + '/' + value;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#sub_cat_select').html(response.items_html);
                }
            })
        });
    </script>
@endsection
