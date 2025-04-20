"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'type_name', name: 'type_name'},
        {data: 'need_company_name', name: 'need_company_name'},
        {data: 'need_company_licence_file', name: 'need_company_licence_file'},
        {data: 'need_company_licence_no', name: 'need_company_licence_no'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#lawyer_types_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'lawyer-types',
            columns: cols
        });

    $(document).on('click', '.btn_edit_lawyer_types', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#edit_lawyer_types_form #id').val(response.item.id);
                $('#edit_lawyer_types_form #type_name').val(response.item.type_name);
                $('#edit_lawyer_types_form #need_company_name').val(response.item.need_company_name).change();
                $('#edit_lawyer_types_form #need_company_licence_file').val(response.item.need_company_licence_file).change();
                $('#edit_lawyer_types_form #need_company_licence_no').val(response.item.need_company_licence_no).change();
                $('#edit_lawyer_types_modal').modal('show');
            }
        })

    })

    $('#edit_lawyer_types_form').submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();
        let url = $(this).attr('action');
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "تم التعديل !",
                    text: " تم تعديل معلومات  بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {

                $.each(error.responseJSON.errors, function (key, value) {
                    $('.lawyer_types_update_' + key + '_error').text(value);
                });
                $('#edit_lawyer_types_modal').modal('show');

            }

        })
    })
    $(document).on('click', '.btn-delete-lawyer_types', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_land",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_land').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_lawyer_types_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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

    $('#save_lawyer_types_form').submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "تم الحفظ !",
                    text: " تم حفظ معلومات الجنسية بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.lawyer_types_save_' + key + '_error').text(value);
                });
                $('#save_lawyer_types_modal').modal('show');

            }

        })
    })


});
