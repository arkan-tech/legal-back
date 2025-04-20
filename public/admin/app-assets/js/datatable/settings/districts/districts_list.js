"use strict";

$(function () {
    var cols = [
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {data: 'country', name: 'country'},
        {data: 'region', name: 'region'},
        {data: 'city', name: 'city'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]

    var table1 = $('#districts_list_table').DataTable(
        {
            processing: true,
            serverSide: true,
            colReorder: true,
            order: [],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l>' +
                '<"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>>',
            ajax: 'districts',
            columns: cols
        });


    $(document).on('click', '.btn_edit_districts', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#edit_district_form #id').val(response.district.id);
                $('#edit_district_form #name').val(response.district.title);
                $("#edit_district_form #edit_country_id_select").val(response.district.country_id).change();
                $("#edit_district_form #edit_region_id_select").val(response.district.region_id).change();
                $("#edit_district_form #edit_city_id_select").val(response.district.city_id).change();
                $('#edit_districts_modal').modal('show');

            }
        })

    })


    $('#edit_district_form').submit(function (event) {
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
                    text: " تم تعديل معلومات الحي بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.district_edit_' + key + '_error').text(value);
                });
                $('#edit_cities_modal').modal('show');

            }

        })
    })


    $(document).on('click', '.btn-delete-cities', function (e) {
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
                    $('body #btn_delete_cities_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
                    setTimeout(() => {
                        Swal.fire({
                            icon: "success",
                            title: "تم الحذف !",
                            text: " تم حذف الحي بنجاح. ",
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


//// ok //////
    $(document).on('click', '#add_new_district_btn', function () {
        $('#save_districts_modal').modal('show');
    });
    $('#save_district_form').submit(function (event) {
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
                    text: " تم حفظ معلومات الحي بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function () {
                    location.reload();
                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.district_save_' + key + '_error').text(value);
                });
                $('#save_districts_modal').modal('show');

            }

        })
    })

});
