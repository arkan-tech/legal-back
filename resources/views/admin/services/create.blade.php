@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            {{--            @include('admin.layouts.alerts.errors') --}}
            @if (Session::has('error-phone'))
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading"> خطأ في البيانات</h4>
                    <div class="alert-body">
                        <div class="">
                            <ul>
                                <li>{{ Session::get('error-sections') }}</li>
                            </ul>
                        </div>
                    </div>

                </div>
            @endif
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->
                        <form action="{{ route('admin.services.store') }}" method="post" id="save_services_form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">حفظ بيانات الخدمة </h4>
                                </div>
                                <div class="card-body">
                                    <label class="mt-2 mb-1">العنوان : </label>
                                    <div class="mb-1">
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror" />
                                        @error('name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <label> القسم الرئيسي: </label>
                                    <div class="mb-1">
                                        <select name="category_id" id="category_id"
                                            class="form-control select2 @error('category_id') is-invalid @enderror">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>




                                    <label>تعريف عن الخدمة : </label>
                                    <div class="mb-1">
                                        <textarea id="intro" name="intro" rows="3" class="form-control @error('intro') is-invalid @enderror"> </textarea>
                                        @error('intro')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <label> التخصص : </label>
                                    <div class="mb-1">
                                        <select name="section_id[]" multiple="multiple" id="sections"
                                            class="form-control select2 @error('section_id') is-invalid @enderror">
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('section_id')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>السعر الادني : </label>
                                    <div class="mb-1">
                                        <input type="number" id="min_price" name="min_price"
                                            class="form-control @error('min_price') is-invalid @enderror" />
                                        @error('min_price')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <label>السعر الاقصى : </label>
                                    <div class="mb-1">
                                        <input type="number" id="max_price" name="max_price"
                                            class="form-control @error('max_price') is-invalid @enderror" />
                                        @error('max_price')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>سعر يمتاز الاصلي : </label>
                                    <div class="mb-1">
                                        <input type="number" id="ymtaz_price" name="ymtaz_price"
                                            class="form-control  @error('ymtaz_price') is-invalid @enderror" />
                                        @error('ymtaz_price')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label> الصورة : </label>
                                    <div class="mb-1">
                                        <input type="file" id="image" name="image"
                                            class="form-control @error('ymtaz_price') is-invalid @enderror"
                                            accept=".png,.jpg ,.jpeg" />
                                        @error('image')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <label> الأسعار حسب مستويات الطلب : </label>


                                    <div class="mb-1 repeater-level-price">
                                        <div data-repeater-list="levels" class=" form-group mt-3">
                                            <div data-repeater-item>
                                                <div class="row d-flex align-items-end">
                                                    <div class=" col-md-5 col-12">
                                                        <div class="mb-1">
                                                            <label>المستوى</label>
                                                            <select name="level_id" required class="form-control select2">
                                                                <option value="">-- اختر --
                                                                </option>
                                                                @foreach ($request_levels as $request_level)
                                                                    <option value="{{ $request_level->id }}">
                                                                        {{ $request_level->title }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12 ">
                                                        <div class="mb-1">
                                                            <label>السعر</label>
                                                            <input type="number" name="price" required
                                                                placeholder="السعر" class="form-control " maxlength="5"
                                                                pattern="[0-9]"
                                                                oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-12 mb-50">
                                                        <div class="mb-1">
                                                            <button class="btn btn-outline-danger text-nowrap px-1"
                                                                data-repeater-delete type="button">
                                                                <i data-feather="x" class="me-25"></i>
                                                                <span>ازالة</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-icon btn-primary" type="button"
                                                    data-repeater-create>
                                                    <i data-feather="plus" class="me-25"></i>
                                                    <span>اضافة مستوى </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                            </div>



                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ
                                </button>
                                <a href="{{ route('admin.services.index') }}"
                                    class="btn btn-outline-secondary mt-1">الرجوع
                                    للاصل
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
        // form repeater jquery
        $('.repeater-level-price').repeater({

            show: function() {
                $(this).slideDown();
                // Feather Icons
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                    $(this).find('select').next('.select2-container').remove();
                    $(this).find('select').select2();
                }
            },
            hide: function(deleteElement) {
                if (confirm('هل انت متأكد من حذف العنصر ؟')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });
    </script>
@endsection
