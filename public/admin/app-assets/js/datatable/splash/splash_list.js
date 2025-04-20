"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'description', name: 'description'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#splash_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'splash',
            columns: cols
        });

    $(document).on('click', '.btn_edit_splash', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#edit_splash_form #id').val(response.item.id);
                $('#edit_splash_form #title').val(response.item.description);
                $('#edit_splash_form #image').attr('src',response.item.image);
                $('#edit_splash_modal').modal('show');
            }
        })

    })

    $('#edit_splash_form').submit(function (event) {
        event.preventDefault();
        let formData =getFormInputs($(this));
        let url = $(this).attr('action');
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "تم التعديل !",
                    text: " تم تعديل  بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {

                $.each(error.responseJSON.errors, function (key, value) {
                    $('.splash_update_' + key + '_error').text(value);
                });
                $('#edit_splash_modal').modal('show');

            }

        })
    })
    $(document).on('click', '.btn-delete-splash', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_splash",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_splash').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_splash_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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

    $('#save_splash_form').submit(function (event) {
        event.preventDefault();
        let formData = getFormInputs($(this));
        let url = $(this).attr('action');
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "تم الحفظ !",
                    text: " تم حفظ  بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.splash_save_' + key + '_error').text(value);
                });
                $('#save_splash_modal').modal('show');
            }

        })
    })
});
