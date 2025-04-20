"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'client', name: 'client'},
        {data: 'service', name: 'service'},
        {data: 'status', name: 'status'},
        {data: 'replay_status', name: 'replay_status'},
        {data: 'referral_status', name: 'referral_status'},
        {data: 'transaction_complete', name: 'transaction_complete'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#service_request_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'service-request',
            columns: cols
        });


    $(document).on('click', '.btn-delete-client-service-request', function (e) {
        e.preventDefault();
        let actionUrl = $(this).attr('href');
        let pid = $(this).attr('data-id');
        Swal.fire({
            title: "تأكيد الحذف ؟",
            text: "هل انت متأكد من عملية الحذف !",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "نعم , حذف",
            cancelButtonText: "الغاء",
            customClass: {
                confirmButton: "btn btn-primary confirm_btn_delete_client_service_request",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_delete_client_service_request').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_client_service_request_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
                    setTimeout(() => {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحذف !",
                            text: " تم حذف الرسالة بنجاح. ",
                            confirmButtonText: 'موافق',
                            customClass: {confirmButton: "btn btn-success"}
                        })
                    }, 1000);
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
            });

        })

    });

    $(document).on('click', '.btn-show-client-service-request', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#show_client_service_request_modal #client_name').html(response.item.client.myname);
                $('#show_client_service_request_modal #client_phone').html(response.item.client.mobil);
                $('#show_client_service_request_modal #client_email').html(response.item.client.email);
                $('#show_client_service_request_modal #service').html(response.item.type.title);
                $('#show_client_service_request_modal #priority').html(response.item.priority == 1 ? 'عاجل جداً' : 'مرتبط بموعد');
                $('#show_client_service_request_modal #description').html(response.item.description);
                $('#show_client_service_request_modal .download_service_request_file_show').attr('id', 'download_service_request_file_show_' + response.item.id);
                let file = response.item.file;
                if (file != null) {
                    if ($('#download_service_request_file_show_' + response.item.id).hasClass('d-none')) {
                        $('#download_service_request_file_show_' + response.item.id).removeClass('d-none');
                    }
                    $('#download_service_request_file_show_' + response.item.id).attr('href', file);
                } else {
                    $('#download_service_request_file_show_' + response.item.id).addClass('d-none');
                }

                if (response.item.replay_status == 1) {
                    $('#show_client_service_request_modal #replay').html(response.item.replay);

                    $('#show_client_service_request_modal .download_service_request_replay_file').attr('id', 'download_service_request_replay_file_' + response.item.id);
                    let replay_file = response.item.replay_file;
                    if (replay_file != null) {
                        $('#download_service_request_replay_file_' + response.item.id).attr('href', replay_file);
                        if ($('#download_service_request_replay_file_' + response.item.id).hasClass('d-none')) {
                            $('#download_service_request_replay_file_' + response.item.id).removeClass('d-none');
                        }
                    } else {
                        $('#download_service_request_replay_file_' + response.item.id).removeAttr('href');
                        $('#download_service_request_replay_file_' + response.item.id).addClass('d-none');
                    }

                    if ($('#show_client_service_request_modal #admin_replay_status_div').hasClass('d-none')) {
                        $('#show_client_service_request_modal #admin_replay_status_div').removeClass('d-none');
                    }
                    if ($('#show_client_service_request_modal .download_service_request_replay_file').hasClass('d-none')) {
                        $('#show_client_service_request_modal .download_service_request_replay_file').removeClass('d-none');
                    }

                } else {
                    if (!$('#show_client_service_request_modal #admin_replay_status_div').hasClass('d-none')) {
                        $('#show_client_service_request_modal #admin_replay_status_div').addClass('d-none');
                    }
                    if (!$('#show_client_service_request_modal .download_service_request_replay_file').hasClass('d-none')) {
                        $('#show_client_service_request_modal .download_service_request_replay_file').addClass('d-none');
                    }
                }
                if (response.rate) {
              if (response.rate.comment != null) {
                        $('#show_client_service_request_modal #comment').removeClass('d-none');
                        $('#show_client_service_request_modal #comment_content').html(response.rate.comment);

                    } else {
                        $('#show_client_service_request_modal #comment #comment_content').addClass('d-none');

                    }
                }
                $('#show_client_service_request_modal').modal('show');
            }
        })

    });


    $(document).on('click', '.btn-replay-client-service-request', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#replay_client_service_request_form #id').val(response.item.id);
                $('#replay_client_service_request_form #client_name').html(response.item.client.myname);
                $('#replay_client_service_request_form #client_phone').html(response.item.client.mobil);
                $('#replay_client_service_request_form #client_email').html(response.item.client.email);
                $('#replay_client_service_request_form #service').html(response.item.type.title);
                $('#replay_client_service_request_form #priority').html(response.item.priority == 1 ? 'عاجل جداً' : 'مرتبط بموعد');
                $('#replay_client_service_request_form #description').html(response.item.description);
                $('#replay_client_service_request_form .download_service_request_file').attr('id', 'download_service_request_file_' + response.item.id);
                let file = response.item.file;
                if (file != null) {
                    if ($('#download_service_request_file_' + response.item.id).hasClass('d-none')) {
                        $('#download_service_request_file_' + response.item.id).removeClass('d-none');
                    }
                    $('#download_service_request_file_' + response.item.id).attr('href', file);
                } else {
                    $('#download_service_request_file_' + response.item.id).addClass('d-none');
                }
                $('#replay_client_service_request_modal').modal('show');
            }
        })

    });

    $('#replay_client_service_request_form').submit(function (event) {
        event.preventDefault();
        let formData = new FormData($(this)[0]);
        let actionUrl = $(this).attr('action');
        $.ajax({
            'url': actionUrl,
            'type': 'post',
            'data': formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('.confirm_replay_service_request_btn').html(('<div class="fa fa-spinner fa-spin"></div>'))
            },
            success: function (response) {
                $('.replay_client_service_request_form').html('ارسال الرد');
                $('.confirm_replay_service_request_btn').attr('disabled', false);
                $('#replay_client_service_request_modal').modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "تم الارسال !",
                    text: " تم ارسال الرد عبر الايميل  بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                });
            },
            error: function () {
                Swal.fire({
                    title: "مشكلة !",
                    text: " هناك مشكلة في النظام يرجى مراجعة مدير النظام !",
                    icon: "error",
                    confirmButtonText: "موافق",
                    customClass: {confirmButton: "btn btn-primary"},
                    buttonsStyling: !1
                }).then(function () {
                    $('.replay_client_service_request_form').html('ارسال الرد');

                    $('.confirm_replay_service_request_btn').attr('disabled', false);

                });
            }
        })
    });

    //
    // $(document).on('click', '.btn-edit-client-service-request', function (e) {
    //     e.preventDefault();
    //     let btn = $(this);
    //     let actionUrl = btn.attr('href');
    //     let data_id = btn.attr('data-id');
    //     $.ajax({
    //         url: actionUrl,
    //         type: 'get',
    //         success: function (response) {
    //             $('#edit_client_service_request_modal #id').val(response.item.id);
    //             $('#edit_client_service_request_modal #client_name').html(response.item.client.myname);
    //             $('#edit_client_service_request_modal #client_phone').html(response.item.client.mobil);
    //             $('#edit_client_service_request_modal #client_email').html(response.item.client.email);
    //             $('#edit_client_service_request_modal #service').html(response.item.type.title);
    //             $('#edit_client_service_request_modal #priority').html(response.item.priority == 1 ? 'عاجل جداً' : 'مرتبط بموعد');
    //             $('#edit_client_service_request_modal #description').html(response.item.description);
    //             $('#edit_client_service_request_modal #payment_status').val(response.item.payment_status).change();
    //             $('#edit_client_service_request_modal').modal('show');
    //         }
    //     })
    //
    // });
    // $('#edit_client_service_request_form').submit(function (event) {
    //     event.preventDefault();
    //     let formData = $(this).serialize();
    //     let actionUrl = $(this).attr('action');
    //     $.ajax({
    //         'url': actionUrl,
    //         'type': 'post',
    //         'data': formData,
    //
    //         success: function (response) {
    //             $('#edit_client_service_request_modal').modal('hide');
    //             Swal.fire({
    //                 icon: "success",
    //                 title: "تم التعديل !",
    //                 text: " تم تحديث بيانات الطلب بنجاح. ",
    //                 confirmButtonText: 'موافق',
    //                 customClass: {confirmButton: "btn btn-success"}
    //             }).then(function (){
    //                 location.reload();
    //             });
    //         },
    //         error: function () {
    //             Swal.fire({
    //                 title: "مشكلة !",
    //                 text: " هناك مشكلة في النظام يرجى مراجعة مدير النظام !",
    //                 icon: "error",
    //                 confirmButtonText: "موافق",
    //                 customClass: {confirmButton: "btn btn-primary"},
    //                 buttonsStyling: !1
    //             }).then(function (){
    //                 $('.replay_client_service_request_form').html('ارسال الرد');
    //
    //                 $('.confirm_replay_service_request_btn').attr('disabled',false);
    //
    //             });
    //         }
    //     })
    // });

});
