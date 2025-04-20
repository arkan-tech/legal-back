"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'phone_code', name: 'phone_code'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#countries_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'countries',
            columns: cols
        });

    $(document).on('click', '.btn_edit_country', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#edit_country_form #id').val(response.country.id);
                $('#edit_country_form #name').val(response.country.name);
                $('#edit_country_form #code').val(response.country.phone_code);
                $('#edit_country_modal').modal('show');
            }
        })

    })

    $('#edit_country_form').submit(function (event) {
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
                    text: " تم تعديل معلومات الدولة بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function (){
                    location.reload();
                })
            },
            error: function (error) {

                $.each(error.responseJSON.errors, function (key, value) {
                    $('.country_update_' + key+'_error').text(value);
                });
                $('#edit_country_modal').modal('show');

            }

        })
    })
    $(document).on('click', '.btn-delete-country', function (e) {
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
                    $('body #btn_delete_country_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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

    $('#save_country_form').submit(function (event) {
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
                    text: " تم حفظ معلومات الدولة بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function (){
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.country_save_' + key+'_error').text(value);
                });
                $('#save_country_modal').modal('show');

            }

        })
    })


    document.querySelector("#save_country_form #code").addEventListener("keypress", function (evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
    });

    document.querySelector("#edit_country_form #code").addEventListener("keypress", function (evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
    });

});
