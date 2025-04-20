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
            <section class="">
                <div class="auto-container">
                    <div class="row clearfix">
                        <div class="form-column column col-lg-12 col-md-12 col-sm-12">
                            <div class="sec-title">
                                <a style="padding: 15px 30px; float: left; background-color: #dd9b25"
                                   class="theme-btn btn-style-three"
                                   href="{{route('site.lawyer.electronic-office.dashboard.contact-ymtaz.create',$id)}}">
                        <span class="txt" style="font-size: 15px;">
                            <i class="fa fa-plus"></i> راسل يمتاز
                        </span>
                                </a>
                                <h5 style="display: inline-block"></h5>
                                <div class="separate"></div>
                            </div>
                            @if(Session::has('success'))
                                <div class="alert alert-primary" role="alert">
                                    <div class="alert-body">
                                        {{Session::get('success')}}
                                    </div>
                                </div>
                            @endif
                            <!--Login Form-->
                            <table class="table table-inbox table-hover text-center">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>عنوان الرسالة</th>
                                    <th>التفاصيل</th>
                                    <th>نوع الرسالة</th>
                                    <th>تاريخ الرسالة</th>
                                    <th> رد يمتاز</th>
                                </tr>
                                <tbody>
                                @foreach($messages as $request)
                                    <tr class="text-center">
                                        <td class="view-message ">
                                            {{ $request->id }}
                                        </td>
                                        <td class="view-message ">
                                            {{ $request->subject }}
                                        </td>
                                        <td class="view-message ">
                                            <div
                                                style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                class="span4 proj-div" data-toggle="modal"
                                                data-target="#GSCCModal{{$request->id}}">
                                                محتوى الرسالة
                                            </div>
                                            <div id="GSCCModal{{$request->id}}" class="modal fade" tabindex="-1"
                                                 role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel"> محتوى
                                                                الرسالة </h4>
                                                        </div>
                                                        <div class="modal-body text-right">
                                                            {{ $request->details }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">اغلاق
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="inbox-small-cells ">
                                            {{ $request->type() }}
                                        </td>
                                        <td class="view-message ">
                                            {{GetArabicDate2($request->created_at)}}
                                        </td>
                                        @if ($request->reply != '')
                                            <td>
                                                <div
                                                    style="cursor: pointer; background: #dd9b25; text-align: center; color: #fff; padding: 8px 0px;"
                                                    class="span4 proj-div" data-toggle="modal"
                                                    data-target="#modal{{$request->id}}">
                                                    عرض رد يمتاز
                                                </div>
                                                <div id="modal{{$request->id}}" class="modal fade" tabindex="-1"
                                                     role="dialog" aria-labelledby="myModalLabel1"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title"
                                                                    id="myModalLabel1"> {{ $request->ymtaz_reply_subject }} </h4>
                                                            </div>
                                                            <div class="modal-body text-justify">
                                                                {{ $request->reply }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">اغلاق
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
@section('electronic_office_site_scripts')
    <script>
        $(document).on('click', '.delete_electronic_office_service_btn', function (e) {
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
                            $('#delete_electronic_office_service_btn_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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
