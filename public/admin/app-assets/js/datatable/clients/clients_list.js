"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'myname', name: 'myname'},
        {data: 'email', name: 'email'},
        {data: 'country', name: 'country'},
        {data: 'mobil', name: 'mobil'},
        {data: 'phone_code', name: 'phone_code'},
        {data: 'type', name: 'type'},
        {data: 'accepted', name: 'accepted'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#digital_guide_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'clients',
            columns: cols
        });

    $(document).on('click', '.btn-delete-client', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_client",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_client').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_client_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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


    $(document).on('click', '.btn-client-send-email', function (e) {
        e.preventDefault();
        let btn = $(this);
        let data_id = btn.attr('data-id');
        $('#send_client_message_form #id').val(data_id);
        $('#send_client_message_modal').modal('show');

    });

    $('#send_client_message_form').submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();
        let actionUrl = $(this).attr('action');
        $.ajax({
            'url': actionUrl,
            'type': 'post',
            'data': formData,
            success: function (response) {
                $('#send_client_message_modal').modal('hide');
                $('#send_client_message_form')[0].reset();
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
    $('#client_accepted_select').on('change', function () {
        table1.search($(this).val(), 'accepted').draw();
    })
});
