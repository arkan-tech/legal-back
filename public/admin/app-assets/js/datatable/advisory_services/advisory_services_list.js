"use strict";

$(function () {
    var cols = [
        { data: "id", name: "id" },
        { data: "title", name: "title" },
        { data: "payment_category", name: "payment_category" },
        { data: "min_price", name: "min_price" },
        { data: "max_price", name: "max_price" },
        { data: "ymtaz_price", name: "ymtaz_price" },
        { data: "action", name: "action", orderable: false, searchable: false },
    ];

    var table1 = $("#advisory_services_list_table").DataTable({
        processing: true,
        serverSide: true,
        colReorder: true,
        order: [],
        dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        ajax: "advisory-services",
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
                $("#show_advisory_services_modal #show_min_price").html(
                    response.item.min_price
                );
                $("#show_advisory_services_modal #show_max_price").html(
                    response.item_max_price
                );
                $("#show_advisory_services_modal #show_yamtaz_price").html(
                    response.item.yamtaz_price
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
                    "#edit_advisory_services_form #edit_advisory_services_min_price"
                ).val(response.item.min_price);
                $(
                    "#edit_advisory_services_form #edit_advisory_services_max_price"
                ).val(response.item.max_price);
                $(
                    "#edit_advisory_services_form #edit_advisory_services_yamtaz_price"
                ).val(response.item.yamtaz_price);
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
});
