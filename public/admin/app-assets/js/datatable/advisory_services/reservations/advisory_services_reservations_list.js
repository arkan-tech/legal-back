"use strict";

$(function () {
    var cols = [
        { data: "id", name: "id" },
        { data: "client", name: "client" },
        { data: "advisory_service", name: "advisory_service" },
        { data: "type", name: "type" },
        { data: "importance_rel", name: "importance_rel" },
        { data: "price", name: "price" },
        { data: "transaction_complete", name: "transaction_complete" },
        { data: "reservation_status", name: "reservation_status" },
        { data: "created_at", name: "created_at" },
        { data: "action", name: "action", orderable: false, searchable: false },
    ];

    var table1 = $("#advisory_services_reservations_list_table").DataTable({
        processing: true,
        serverSide: true,
        colReorder: true,
        order: [],
        dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        ajax: "client-advisory-services-reservations",
        columns: cols,
    });

    $(document).on("click", ".btn_show_advisory_services", function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr("href");
        $.ajax({
            url: actionUrl,
            type: "get",
            success: function (response) {
                $("#show_advisory_services_modal #show_title").html(
                    response.item.title
                );
                $("#show_advisory_services_modal #show_price").html(
                    response.item.price
                );
                $("#show_advisory_services_modal #show_phone").html(
                    response.item.phone
                );
                $("#show_advisory_services_modal #show_description").html(
                    response.item.description
                );
                $("#show_advisory_services_modal #show_image").attr(
                    "src",
                    response.item.image
                );
                $("#show_advisory_services_modal").modal("show");
            },
        });
    });

    $(document).on("click", ".btn_edit_advisory_services", function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr("href");
        let data_id = btn.attr("data-id");
        $.ajax({
            url: actionUrl,
            type: "get",
            success: function (response) {
                $("#edit_advisory_services_form #id").val(response.item.id);
                $(
                    "#edit_advisory_services_form #edit_advisory_services_name"
                ).val(response.item.title);
                $(
                    "#edit_advisory_services_form #edit_advisory_services_description"
                ).html(response.item.description);
                $(
                    "#edit_advisory_services_form #edit_advisory_services_price"
                ).val(response.item.price);
                $(
                    "#edit_advisory_services_form #edit_advisory_services_phone"
                ).val(response.item.phone);
                $(
                    "#edit_advisory_services_form #edit_advisory_services_show_image"
                ).attr("src", response.item.image);
                $("#edit_advisory_services_modal").modal("show");
            },
        });
    });

    $("#edit_advisory_services_form").submit(function (event) {
        event.preventDefault();
        let formData = getFormInputs($(this));
        let url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "تم التعديل !",
                    text: " تم تعديل معلومات حالة وظيفية بنجاح. ",
                    confirmButtonText: "موافق",
                    customClass: { confirmButton: "btn btn-success" },
                }).then(function () {
                    location.reload();
                });
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $(".advisory_services_update_" + key + "_error").text(
                        value
                    );
                });
                $("#edit_advisory_services_modal").modal("show");
            },
        });
    });

    $(document).on("click", ".btn-delete-advisory-services", function (e) {
        e.preventDefault();
        let actionUrl = $(this).attr("href");
        let pid = $(this).attr("data-id");
        Swal.fire({
            title: "تأكيد الحذف ؟",
            text: "هل انت متأكد من عملية الحذف !",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "نعم , حذف",
            cancelButtonText: "الغاء",
            customClass: {
                confirmButton: "btn btn-primary confirm_btn_advisory_services",
                cancelButton: "btn btn-outline-danger ms-1",
            },
            buttonsStyling: !1,
        });
        $(".confirm_btn_advisory_services").on("click", function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: "get",
                success: function (response) {
                    $("body #btn_delete_advisory_services_" + pid)
                        .closest("tr")
                        .css("background", "#714f4f")
                        .delay(500)
                        .hide(500);
                    setTimeout(() => {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحذف !",
                            text: " تم الحذف  بنجاح. ",
                            confirmButtonText: "موافق",
                            customClass: { confirmButton: "btn btn-success" },
                        });
                    }, 1000);
                },
                error: function () {
                    Swal.fire({
                        title: "مشكلة !",
                        text: " هناك مشكلة في النظام يرجى مراجعة مدير النظام !",
                        icon: "error",
                        confirmButtonText: "موافق",
                        customClass: { confirmButton: "btn btn-primary" },
                        buttonsStyling: !1,
                    });
                },
            });
        });
    });

    $("#save_advisory_services_form").submit(function (event) {
        event.preventDefault();
        let formData = getFormInputs($(this));
        let url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "تم الحفظ !",
                    text: " تم حفظ المعلومات بنجاح. ",
                    confirmButtonText: "موافق",
                    customClass: { confirmButton: "btn btn-success" },
                }).then(function () {
                    location.reload();
                });
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $(".advisory_services_save_" + key + "_error").text(value);
                });
                $("#save_advisory_services_modal").modal("show");
            },
        });
    });

    $(document).on(
        "click",
        ".btn-replay-client-advisory-services-reservations",
        function (e) {
            e.preventDefault();
            let btn = $(this);
            let actionUrl = btn.attr("href");
            let data_id = btn.attr("data-id");
            $.ajax({
                url: actionUrl,
                type: "get",
                success: function (response) {
                    $("#replay_client_advisory_reservations_form #id").val(
                        response.item.id
                    );
                    $(
                        "#replay_client_advisory_reservations_form #client_id"
                    ).val(response.item.client_id);
                    $(
                        "#replay_client_advisory_reservations_form #client_name"
                    ).text(response.item.client.myname);
                    $(
                        "#replay_client_advisory_reservations_form #client_phone"
                    ).text(
                        response.item.client.phone_code +
                            response.item.client.mobil
                    );
                    $(
                        "#replay_client_advisory_reservations_form #client_email"
                    ).text(response.item.client.email);
                    $(
                        "#replay_client_advisory_reservations_form #message_item"
                    ).text(response.item.description);
                    $(
                        "#replay_client_advisory_reservations_form .download_file"
                    ).attr("id", "download_file_" + response.item.id);

                    let file = response.item.file;
                    if (file != null) {
                        $("#download_file_" + response.item.id).attr(
                            "href",
                            file
                        );
                        $("#download_file_" + response.item.id).attr(
                            "download",
                            file
                        );
                    } else {
                        $("#download_file_" + response.item.id).addClass(
                            "d-none"
                        );
                    }
                    $("#replay_client_advisory_reservations_modal").modal(
                        "show"
                    );
                },
            });
        }
    );

    $("#replay_client_advisory_reservations_form").submit(function (event) {
        event.preventDefault();
        let formData = getFormInputs($(this));
        let url = $(this).attr("action");
        $.ajax({
            url: url,
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "نجاح !",
                    text: "تم ارسال الرد بنجاح . ",
                    confirmButtonText: "موافق",
                    customClass: { confirmButton: "btn btn-success" },
                }).then(function () {
                    location.reload();
                });
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $(".client_advisory_reservations_" + key + "_error").text(
                        value
                    );
                });
                $("#replay_client_advisory_reservations_modal").modal("show");
            },
        });
    });
});
