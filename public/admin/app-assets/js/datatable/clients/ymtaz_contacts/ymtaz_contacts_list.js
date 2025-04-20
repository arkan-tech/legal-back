"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'client_name', name: 'lawyer_name'},
        {data: 'client_email', name: 'lawyer_email'},
        {data: 'subject', name: 'subject'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#client_ymtaz_messages_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'ymtaz-contacts',
            columns: cols
        });

    $(document).on('click', '.btn-delete-client-ymtaz-message', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_delete_client_ymtaz_message",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_delete_client_ymtaz_message').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_client_ymtaz_message_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
                    setTimeout(() => {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحذف !",
                            text: " تم الحذف  بنجاح. ",
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


    $(document).on('click', '.btn-replay-client-ymtaz-message', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                console.log(response.message.name);
                $('#replay_client_ymtaz_message_form #id').val(response.message.id);
                $('#replay_client_ymtaz_message_form #name').html(response.message.client.myname);
                $('#replay_client_ymtaz_message_form #phone').html(response.message.client.mobil);
                $('#replay_client_ymtaz_message_form #email').html(response.message.client.email);
                $('#replay_client_ymtaz_message_form #subject').html(response.message.subject);
                $('#replay_client_ymtaz_message_form #message').html(response.message.details);
                $('#replay_client_ymtaz_message_form #type').html(getMessageType(response.message.type));
                $('#replay_client_ymtaz_message_form .download_client_ymtaz_message_file').attr('id','download_client_ymtaz_message_file_'+response.message.id);
                let file = response.message.file;
                if (file != null) {
                    $('#download_client_ymtaz_message_file_'+response.message.id).attr('href',file);
                    $('#download_client_ymtaz_message_file_'+response.message.id).attr('download',file);
                }else {
                    $('#download_client_ymtaz_message_file_'+response.message.id).addClass('d-none');

                }
                $('#replay_client_ymtaz_message_modal').modal('show');
            }
        })

    });

    $('#replay_client_ymtaz_message_form').submit(function (event) {
        event.preventDefault();
        let formData = getFormInputs($(this));
        let actionUrl = $(this).attr('action');
        $('.confirm_replay_client_ymtaz_message_btn').html(('<div class="fa fa-spinner fa-spin"></div>'))
        $.ajax({
            'url': actionUrl,
            'type': 'post',
            'data': formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('.confirm_replay_client_ymtaz_message_btn').html('ارسال الرد')
                $('#replay_client_ymtaz_message_modal').modal('hide');
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
