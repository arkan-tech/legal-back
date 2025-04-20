"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'lawyer', name: 'lawyer'},
        {data: 'organization', name: 'organization'},
        {data: 'priority', name: 'priority'},
        {data: 'status', name: 'status'},
        {data: 'price', name: 'price'},
        {data: 'payment_status', name: 'payment_status'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#organization_requests_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: 'organization-requests',
            columns: cols
        });

    $(document).on('click', '.btn-delete-organization-requests', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_organization_requests",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_organization_requests').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('body #btn_delete_organization_requests_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
                    setTimeout(() => {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحذف !",
                            text: " تم الحذف بنجاح. ",
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

    $(document).on('click', '.btn-replay-organization-requests', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#replay_organization_request_form #id').val(response.item.id);
                $('#replay_organization_request_form #lawyer_id').val(response.item.lawyer_id);
                $('#replay_organization_request_form #lawyer_name').text(response.item.lawyer.name);
                $('#replay_organization_request_form #lawyer_phone').text( response.item.lawyer.phone_code + response.item.lawyer.phone_code );
                $('#replay_organization_request_form #lawyer_email').text( response.item.lawyer.email);
                $('#replay_organization_request_form #advis_title').text( response.item.organization.title);
                $('#replay_organization_request_form #message_item').text( response.item.description);
                $('#replay_organization_request_form .download_file').attr('id','download_file_'+response.item.id);

                let file = response.item.file;
                if (file !=null) {
                    $('#download_file_'+response.item.id).attr('href',file);
                    $('#download_file_'+response.item.id).attr('download',file);

                }else {
                    $('#download_file_'+response.item.id).addClass('d-none');

                }
                $('#replay_organization_request_modal').modal('show');
            }
        })
    });

    $('#replay_organization_request_form').submit(function (event) {
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
                    title: "نجاح !",
                    text: "تم ارسال الرد بنجاح . ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.organization_request_replay_' + key + '_error').text(value);
                });
                $('#replay_organization_request_modal').modal('show');

            }

        })
    })

});
