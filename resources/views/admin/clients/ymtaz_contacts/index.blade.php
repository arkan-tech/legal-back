@extends('admin.layouts.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            @include('admin.layouts.alerts.success')
            <div class="content-body">
                <!-- equipments list start -->
                <section class="app-equipment-list">
                    <div class="card">
                        <div class="mb-12 p-2">
                            <div class="row align-items-center">

                            </div>
                        </div>

                        <div class="card-datatable table-responsive pt-0">
                            <table class="table text-center" id="client_ymtaz_messages_list_table">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th> الاسم</th>
                                    <th> الايميل</th>
                                    <th> الموضوع</th>
                                    <th>العمليات</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- equipments list ends -->

            </div>
        </div>
    </div>

    <div class="modal fade text-start" id="replay_client_ymtaz_message_modal" tabindex="-1" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> رد على الرسالة </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="replay_client_ymtaz_message_form" action="{{route('admin.clients.ymtaz-contacts.replay')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label> العميل : </label>
                                <div class="mb-1">
                                    <span id="name" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label> الجوال : </label>
                                <div class="mb-1">
                                    <span id="phone" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label> الايميل : </label>
                                <div class="mb-1">
                                    <span id="email" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label> موضوع الرسالة : </label>
                                <div class="mb-1">
                                    <span id="subject" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> النوع : </label>
                                <div class="mb-1">
                                    <span id="type" class="form-control"/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> الرسالة : </label>
                                <div class="mb-1">
                                    <textarea id="message" rows="3" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> عنوان الرد : </label>
                                <div class="mb-1">
                                    <input name="ymtaz_reply_subject" class="form-control" required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label> الرد : </label>
                                <div class="mb-1">
                                    <textarea name="replay_message" rows="3" class="form-control" required></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary confirm_replay_client_ymtaz_message_btn">ارسال الرد</button>
                            <a class="btn btn-primary download_client_ymtaz_message_file" >
                                تنزيل المرفقات
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{asset('admin/app-assets/js/datatable/clients/ymtaz_contacts/ymtaz_contacts_list.js?'.time())}}"></script>

@endsection
