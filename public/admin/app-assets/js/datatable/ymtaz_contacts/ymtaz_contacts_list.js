"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'lawyer_name', name: 'lawyer_name'},
        {data: 'lawyer_email', name: 'lawyer_email'},
        {data: 'subject', name: 'subject'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#ymtaz_messages_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'ymtaz-contacts',
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
                    $('body #btn_delete_ymtaz_message_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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


    $(document).on('click', '.btn-replay-ymtaz-message', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                console.log(response.message.name);
                $('#replay_ymtaz_message_modal #id').val(response.message.id);
                $('#replay_ymtaz_message_modal #name').html(response.message.lawyer.name);
                $('#replay_ymtaz_message_modal #phone').html(response.message.lawyer.phone_code + response.message.lawyer.phone_code);
                $('#replay_ymtaz_message_modal #email').html(response.message.lawyer.email);
                $('#replay_ymtaz_message_modal #subject').html(response.message.subject);
                $('#replay_ymtaz_message_modal #message').html(response.message.details);
                $('#replay_ymtaz_message_modal #type').html(getMessageType(response.message.type));
                $('#replay_ymtaz_message_modal .download_ymtaz_file').attr('id','download_ymtaz_file_'+response.message.id);
                let file = response.message.file;
                if (file !=null) {
                    $('#download_ymtaz_file_'+response.message.id).attr('href',file);
                    $('#download_ymtaz_file_'+response.message.id).attr('download',file);
                }else {
                    $('#download_ymtaz_file_'+response.message.id).addClass('d-none');

                }
                $('#replay_ymtaz_message_modal').modal('show');
            }
        })

    });

    $('#replay_ymtaz_message_form').submit(function (event) {
        event.preventDefault();
        let formData = getFormInputs($(this));
        let actionUrl = $(this).attr('action');
        $('.confirm_replay_ymtaz_message_btn').html(('<div class="fa fa-spinner fa-spin"></div>'))
        $.ajax({
            'url': actionUrl,
            'type': 'post',
            'data': formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('.confirm_replay_ymtaz_message_btn').html('ارسال الرد')
                $('#replay_ymtaz_message_modal').modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "تم الارسال !",
                    text: " تم ارسال الرسالة بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
           location.reload();
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

    function getMessageType(type) {
        if (type == '1') {
            return 'طلب خدمة';
        } else {
            return 'شكوى أو بلاغ';
        }

    }
});
