"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'phone', name: 'phone'},
        {data: 'user_type', name: 'user_type'},
        {data: 'subject', name: 'subject'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#contact_messages_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'contact-messages',
            columns: cols
        });

    $(document).on('click', '.btn-delete-message', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_delete_message",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_delete_message').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_message_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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
    $(document).on('click', '.btn-show-message', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                console.log(response.message.name);
                $('#show_message_modal #name').html(response.message.name);
                $('#show_message_modal #phone').html(response.message.phone);
                $('#show_message_modal #email').html(response.message.email);
                $('#show_message_modal #subject').html(response.message.subject);
                $('#show_message_modal #message').html(response.message.message);
                $('#show_message_modal').modal('show');
            }
        })

    });


    $(document).on('click', '.btn-replay-message', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                console.log(response.message.name);
                $('#replay_message_modal #id').val(response.message.id);
                $('#replay_message_modal #name').html(response.message.name);
                $('#replay_message_modal #phone').html(response.message.phone);
                $('#replay_message_modal #email').html(response.message.email);
                $('#replay_message_modal #subject').html(response.message.subject);
                $('#replay_message_modal #message').html(response.message.message);
                $('#replay_message_modal').modal('show');
            }
        })

    });

    $('#replay_message_form').submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();
       let actionUrl = $(this).attr('action');
       $('.confirm_replay_message_btn').html(('<div class="fa fa-spinner fa-spin"></div>'))
        $.ajax({
            'url':actionUrl,
            'type':'post',
            'data':formData,
            success:function (response) {
                $('.confirm_replay_message_btn').html('ارسال الرد')
                $('#replay_message_modal').modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "تم الارسال !",
                    text: " تم ارسال الرسالة بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
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
});
