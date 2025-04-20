@extends('site.lawyers.electronic_office.app')
@section('electronic_office_header')
    <!--header-->
    <div class="header-top" style="background-image: url('{{asset('site/electronic_office/images/services.jpg')}}');">
        @include('site.lawyers.electronic_office.layouts.menue')
        <div class="container">
            <div class="align-self-center text-center content-header" style="padding-top: 15% ;margin-bottom: 15%">
                <h2> لوحة التحكم </h2>
            </div>
        </div>
        <section class="page-banner">
            <div class="image-layer"></div>
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="banner-inner">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <h1></h1>
                        <div class="page-nav">
                            <ul class="bread-crumb clearfix">
                                <li><a></a></li>
                                <li class="active"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!---end header-->
@endsection
@section('electronic_office_content')

    <div class="row " style="max-width: 100%">

        <!--Login Form-->
        @include('site.lawyers.electronic_office.dashboard.layouts.side_menue')

        <div class="col-lg-9  mt-3 mb-3">


            <div class="card-header border-bottom text-left">
                <a href="{{route('site.lawyer.electronic-office.dashboard.clients.create',$id)}}"
                   style="background-color: #dd9b25" class="btn btn-primary text-left">اضافة عميل </a>
            </div>

            <div class="card-body text-right ">
                @if(Session::has('success'))
                    <div class="alert alert-primary" role="alert">
                        <div class="alert-body">
                            {{Session::get('success')}}
                        </div>
                    </div>
                @endif

                <table class="table text-center">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">صورة</th>
                        <th scope="col" class="text-center">الاسم</th>
                        <th scope="col" class="text-center">عمليات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr class="text-right">
                            <td class="text-center">{{$client->id}}</td>
                            <td class="text-center" style="width: 20%"><img src="{{$client->image}}" alt=""></td>
                            <td class="text-center">{{$client->name}}</td>
                            <td class="text-center">
                                <a style="color: #dd9b25"
                                   href="{{route('site.lawyer.electronic-office.dashboard.clients.edit',['id'=>$client->id,'electronic_id_code'=>$id])}}"
                                   class="m-2"><i class="fa fa-edit"></i> </a>
                                <a style="color: #dd9b25"
                                   href="{{route('site.lawyer.electronic-office.dashboard.clients.show',['id'=>$client->id,'electronic_id_code'=>$id])}}"
                                   class="m-2"><i class="fa fa-eye"></i> </a>
                                <a data-id="{{$client->id}}" style="color: #dd9b25"
                                   id="delete_electronic_office_client_btn_{{$client->id}}"
                                   href="{{route('site.lawyer.electronic-office.dashboard.clients.delete',['id'=>$client->id,'electronic_id_code'=>$id])}}"
                                   class="delete_electronic_office_client_btn m-2"><i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection
@section('electronic_office_site_scripts')
    <script>
        $(document).on('click', '.delete_electronic_office_client_btn', function (e) {
            e.preventDefault();
            let actionUrl = $(this).attr('href');
            let pid = $(this).attr('data-id');
            Swal.fire({
                title: '  هل انت متأكد من الحذف ؟ ',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'حذف ',
                cancelButtonText: ' الغاء !'
            }).then((result) => {
                $.ajax({
                    url: actionUrl,
                    type: 'get',
                    success: function (response) {
                        Swal.fire(
                            'تم الحذف بنجاح!',
                        ).then(function () {
                            $('#delete_electronic_office_client_btn_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
                        })
                    },
                    error: function () {
                        Swal.fire({
                            title: "مشكلة !",
                            text: " هناك مشكلة في النظام يرجى مراجعة مدير النظام !",
                            icon: "error",
                            confirmButtonText: "موافق",
                            customClass: {confirmButton: "btn btn-primary"},
                            buttonsStyling: !1
                        })
                    }
                })

            })
        })
    </script>
@endsection
