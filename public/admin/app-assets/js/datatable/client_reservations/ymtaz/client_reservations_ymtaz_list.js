"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'client', name: 'client'},
        {data: 'service', name: 'service'},
        {data: 'importance', name: 'importance'},
        {data: 'date', name: 'date'},
        {data: 'time', name: 'time'},
        {data: 'transaction_complete', name: 'transaction_complete'},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#client_reservations_ymtaz_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'client-ymtaz-reservations',
            columns: cols
        });


    $(document).on('click', '.btn_show_client_reservations', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#show_client_reservations_modal #client_name').html(response.item.client.myname);
                $('#show_client_reservations_modal #type_title').html(response.item.type_rel.title);
                $('#show_client_reservations_modal #importance_rel').html(response.item.importance_rel.title);
                $('#show_client_reservations_modal #date').html(response.item.date);
                $('#show_client_reservations_modal #time').html(response.item.fullTime);
                $('#show_client_reservations_modal #notes').html(response.item.notes);
                $('#show_client_reservations_modal').modal('show');
            }
        })

    })

    $(document).on('click', '.btn_edit_client_reservations', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#edit_client_reservations_form #id').val(response.item.id);
                $('#edit_client_reservations_form #edit_client_reservations_name').val(response.item.title);
                $('#edit_client_reservations_modal').modal('show');
            }
        })

    })

    $('#edit_client_reservations_form').submit(function (event) {
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
                    $('.client_reservations_update_' + key + '_error').text(value);
                });
                $('#edit_client_reservations_modal').modal('show');

            }

        })
    })

    $(document).on('click', '.btn-delete-client-reservations', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_client_reservations",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_client_reservations').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_client_reservations_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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

    $('#save_client_reservations_form').submit(function (event) {
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
                    text: " تم حفظ المعلومات بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.client_reservations_save_' + key + '_error').text(value);
                });
                $('#save_client_reservations_modal').modal('show');

            }

        })
    })
});
