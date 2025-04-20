@extends('admin.layouts.app')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @include('admin.layouts.alerts.success')
            @include('admin.layouts.alerts.errors')
            @if(Session::has('error-phone'))
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading"> خطأ في البيانات</h4>
                    <div class="alert-body">
                        <div class="">
                            <ul>
                                <li>{{Session::get('error-sections')}}</li>
                            </ul>
                        </div>
                    </div>

                </div>
            @endif
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <!-- profile -->
                        <form class="mt-2 pt-50 validate-form"
                              action="{{route('admin.clients.update')}}"
                              method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">المعلومات الشخصية</h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- form -->
                                    @csrf
                                    <input type="hidden" name="id" value="{{$client->id}}">

                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountFirstName"> الاسم </label>
                                            <input type="text" class="form-control @error('myname')is-invalid @enderror"
                                                   name="myname" value="{{$client->myname}}"/>
                                            @error('myname')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label for=""> رقم الجوال</label>

                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <select class="form-control select2" required name="phone_code">
                                                        @foreach($countries as $country)
                                                            <option
                                                                value="{{$country->phone_code}}" {{$country->phone_code == $client->phone_code ?'selected':''}}>{{$country->name. ' '.'('.$country->phone_code.' )'}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="number" name="mobil" id="mobil"
                                                       class="form-control"
                                                       minlength="14"
                                                       pattern="\d*"
                                                       min="0"
                                                       oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                       maxlength="14"
                                                       value="{{str_replace($client->phone_code,'',$client->mobil)}}">
                                            </div>
                                            @error('mobil')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> البريد الالكتروني </label>
                                            <input type="email" name="email" id="email"
                                                   class="form-control @error('email') is-invalid @enderror "
                                                   placeholder="البريد الالكتروني" value="{{$client->email}}">
                                            @error('email')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> كلمة المرور </label>
                                            <input type="text" name="password" id="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="كلمة المرور">
                                            @error('password')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="accountEmail"> النوع</label>
                                            <select
                                                class="form-control @error('type') is-invalid @enderror select2"
                                                name="type" id="type_select">
                                                <option {{$client->type =='1' ?'selected' :''}}  value="1">فرد</option>
                                                <option {{$client->type =='2' ?'selected' :''}}  value="2">مؤسسة
                                                </option>
                                                <option {{$client->type =='3' ?'selected' :''}}  value="3">شركة</option>
                                                <option {{$client->type =='4' ?'selected' :''}} value="4">جهة حكومية
                                                </option>
                                                <option {{$client->type =='5' ?'selected' :''}}  value="5">هيئة</option>
                                            </select>
                                            @error('type')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">الجنسية </label>
                                            <select
                                                class="form-control @error('nationality')is-invalid @enderror select2"
                                                id="nationality_select" name="nationality">
                                                <option value=""> اختر</option>
                                                @include('admin.clients.includes.edit.nationality-select')
                                            </select>
                                            @error('nationality')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">الدولة</label>
                                            <select
                                                name="country_id"
                                                class="form-control @error('country_id')is-invalid @enderror select2"
                                                id="country_id_select">
                                                <option value=""> اختر</option>
                                                @include('admin.clients.includes.edit.countries-select')
                                            </select>
                                            @error('country_id')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-4 mb-1">
                                            <label class="form-label" for="accountEmail">المنطقة </label>
                                            <select class="form-control @error('region')is-invalid @enderror select2"
                                                    name="region" id="region_id_select">
                                                <option value=""> اختر</option>
                                                @include('admin.clients.includes.edit.region-select')
                                            </select>
                                            @error('region')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail">المدينة </label>
                                            <select class="form-control @error('city') is-invalid @enderror select2"
                                                    name="city" id="city_id_select">
                                                <option value=""> اختر</option>
                                                @include('admin.clients.includes.edit.cities-select')
                                            </select>
                                            @error('city')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label class="form-label" for="accountEmail"> الجنس</label>
                                            <select name="gender"
                                                    class="form-control @error('gender')is-invalid @enderror">
                                                <option value=""> اختر</option>
                                                <option value="Male" {{$client->gender =='Male' ?'selected':''}}>ذكر
                                                </option>
                                                <option value="Female" {{$client->gender =='Female' ?'selected':''}}>
                                                    انثى
                                                </option>
                                            </select>
                                            @error('gender')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> خط الطول :</label>
                                            <input type="text" readOnly id="lat" name="lat"
                                                   class="form-control"
                                                   placeholder="خط الطول" value="{{$client->latitude}}">
                                            @error('lat')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-sm-6 mb-1">
                                            <label> خط العرض :</label>
                                            <input type="text" readOnly id="lon" name="lon"
                                                   class="form-control"
                                                   placeholder="خط العرض" value="{{$client->longitude}}">
                                            @error('lon')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div style="height: 300px; width: 100%" id='map-canvas'></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"> حالة الحساب</h4>
                                </div>
                                <div class="card-body py-2 my-25 ">
                                    <div class="row mt-1">
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label> حالة القبول :</label>

                                            <select name="accepted"
                                                    id="accepted_select"
                                                    class="form-control @error('accepted') is-invalid @enderror  select2">
                                                <option value="">اختر</option>
                                                <option value="1" {{$client->accepted == 1?'selected':''}}>جديد</option>
                                                <option value="2" {{$client->accepted == 2?'selected':''}}>قبول</option>
                                                <option value="3" {{$client->accepted == 3?'selected':''}}>انتظار
                                                </option>
                                                <option value="0" {{$client->accepted == 0?'selected':''}}>حظر</option>
                                            </select>
                                            @error('accepted')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">حفظ التعديلات
                                </button>
                                <a href="{{route('admin.clients.index')}}" class="btn btn-outline-secondary mt-1">الرجوع
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
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdhYBtJu-w2JmuMNQDZsmXIHRkj8uGQhw&callback&callback=initMap&amp;language=ar-AR">
    </script>
    <script>
        function initMap() {
            var myLatlng = new google.maps.LatLng('{{$client->latitude}}', '{{$client->longitude}}');
            var myOptions = {
                zoom: 10,
                center: myLatlng
            }
            var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
            var geocoder = new google.maps.Geocoder();
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable: true,
                title: "Drag me!"
            });
            marker.addListener('dragend', function (event) {
                $('#lat').val(event.latLng.lat());
                $('#lon').val(event.latLng.lng());
                geocoder.geocode({
                    'latLng': event.latLng
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            //alert(results[0].formatted_address);
                            $('#Settings_address').val(results[0].formatted_address);
                        }
                    }
                });

            });


            google.maps.event.addListener(map, 'click', function (event) {
                geocoder.geocode({
                    'latLng': event.latLng
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            alert(results[0].formatted_address);
                        }
                    }
                });
            });
        }

        $('#country_id_select').on('change', function (e) {
            e.preventDefault();
            let country_id = $(this).val();
            let actionUrl = '{{route('admin.clients.get-regions-bade-country-id')}}' + '/' + country_id;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#region_id_select').html(response.items_html);
                }
            });
        })
        $('#region_id_select').on('change', function (e) {
            e.preventDefault();
            let region_id = $(this).val();
            let actionUrl = '{{route('admin.clients.get-cities-bade-region-id')}}' + '/' + region_id;
            $.get(actionUrl, function (response) {
                if (response.status) {
                    $('#city_id_select').html(response.items_html);
                }
            });
        });

    </script>

@endsection
