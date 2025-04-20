"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#services_categories_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l>' +
                '<"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>>',
            ajax: 'categories',
            columns: cols
        });


    $('#save_categories_categories_form').submit(function (event) {
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
                    text: " تم حفظ المعلومات  بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                Swal.fire({
                    title: "مشكلة !",
                    text: " الرجاء التحقق من جميع الحقول المدخلة !",
                    icon: "error",
                    confirmButtonText: "موافق",
                    customClass: {confirmButton: "btn btn-primary"},
                    buttonsStyling: !1
                }).then(function () {
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.services_categories_save_' + key + '_error').text(value);
                    });
                    $('#save_services_categories_modal').modal('show');
                })

            }

        })
    })

    $(document).on('click', '.btn_edit_services_categories', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#edit_services_categories_form #id').val(response.item.id);
                $('#edit_services_categories_form #name').val(response.item.name);
                $('#edit_services_categories_modal').modal('show');
            }
        })

    })

    $('#edit_services_categories_form').submit(function (event) {
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
                    title: "تم التعديل !",
                    text: " تم تعديل المعلومات  بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.services_categories_update_' + key + '_error').text(value);
                });
                $('#edit_services_categories_modal').modal('show');

            }

        })
    })

    $(document).on('click', '.btn-delete-services-categories', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_services_categories",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_services_categories').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_services_categories_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
                    setTimeout(() => {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحذف !",
                            text: " تم حذف المدينة بنجاح. ",
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
