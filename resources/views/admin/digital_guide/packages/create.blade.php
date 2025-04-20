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
                              action="{{route('admin.digital-guide.packages.store')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> معلومات الباقة</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf

                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountFirstName"> العنوان </label>
                                            <input type="text" class="form-control @error('title')is-invalid @enderror"
                                                   name="title" value="{{old('title')}}" />
                                            @error('title')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> السعر </label>
                                            <input type="number" class="form-control @error('price')is-invalid @enderror"
                                                   name="price"  value="{{old('price')}}"/>
                                            @error('price')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-6 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> المدة </label>
                                            <input type="number" class="form-control @error('period')is-invalid @enderror"
                                                   name="period" value="{{old('period')}}" />
                                            @error('period')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountFirstName"> المحتوى </label>
                                            <textarea type="text" class="form-control  @error('intro')is-invalid @enderror"
                                                      name="intro" rows="5" id="editor">{{old('intro')}}</textarea>
                                            @error('intro')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountFirstName"> قواعد الاشتراك </label>
                                            <textarea type="text" class="form-control  @error('rules') is-invalid @enderror"
                                                      name="rules" rows="5" id="editor_rules">{{old('rules')}}</textarea>
                                            @error('rules')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1">الرجوع للاصل
                                </button>
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
    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: 'ar'
            } )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#editor_rules' ), {
                language: 'ar'
            } )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>

@endsection
