"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'client_name', name: 'client_name'},
        {data: 'lawyer_name', name: 'lawyer_name'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#complaint_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'complains',
            columns: cols
        });

    $(document).on('click', '.btn_show_complaint', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#show_complaint_modal #client_name').text(response.item.client.myname);
                $('#show_complaint_modal #client_email').text(response.item.client.email);
                $('#show_complaint_modal #client_mobile').text(response.item.client.mobil);
                $('#show_complaint_modal #lawyer_name').text(response.item.lawyer.name);
                $('#show_complaint_modal #lawyer_email').text(response.item.lawyer.email);
                $('#show_complaint_modal #lawyer_mobile').text(response.item.lawyer.phone);
                $('#show_complaint_modal #complaint_body').text(response.item.complaint_body);
                $('#show_complaint_modal').modal('show');
            }
        })

    })

    $(document).on('click', '.btn-delete-complaint', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_complaint",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_complaint').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_complaint_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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

});
