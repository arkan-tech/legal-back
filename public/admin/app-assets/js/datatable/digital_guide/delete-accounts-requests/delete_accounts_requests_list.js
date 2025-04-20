"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'lawyer', name: 'lawyer'},
        {data: 'delete_reason', name: 'delete_reason'},
        {data: 'development_proposal', name: 'development_proposal'},
        {data: 'status', name: 'status'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#digital_guide_delete_account_request_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'delete-accounts',
            columns: cols
        });


    $(document).on('click', '.btn-delete-digital-guide-delete-account-request', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_delete_client_delete_account_request",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_delete_client_delete_account_request').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_digital_guide_delete_account_request_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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

    $(document).on('click', '.btn-show-digital-guide-delete-account-request', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#show_client_delete_account_request_modal #client_name').html(response.item.lawyer.name);
                $('#show_client_delete_account_request_modal #client_email').html(response.item.lawyer.email);
                $('#show_client_delete_account_request_modal #delete_reason').html(response.item.delete_reason);
                $('#show_client_delete_account_request_modal #development_proposal').html(response.item.development_proposal);
                $('#show_client_delete_account_request_modal').modal('show');
            }
        })

    });




});
