<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdhYBtJu-w2JmuMNQDZsmXIHRkj8uGQhw&callback&callback=initMap&amp;language=ar-AR">
</script>
<script>
    $(document).ready(function () {
        let identity_type_status = '{{$lawyer->identity_type}}';
        let degree_status = '{{$lawyer->degree}}';
        let has_licence_no = '{{$lawyer->has_licence_no}}';
        let is_advisor = '{{$lawyer->is_advisor}}';
        let lawyer_type = '{{$lawyer->type}}';
        let digital_guide_subscription_value = '{{$lawyer->digital_guide_subscription}}';
        let other_city = '{{$lawyer->city}}';

        if (identity_type_status == 4) {
            var other_idetity_type_dev = document.getElementById("other_idetity_type_dev");
            other_idetity_type_dev.style.display = "block"
        }


        if (degree_status == 4) {
            var other_degree_dev = document.getElementById("other_degree_dev");
            other_degree_dev.style.display = "block"
        }

        // if (has_licence_no == 1) {
        //     var other_degree_dev = document.getElementById("licence_no_dev");
        //     other_degree_dev.style.display = "block"
        // } else {
        //     var other_degree_dev = document.getElementById("licence_no_dev");
        //     other_degree_dev.style.display = "none"
        // }


        if (is_advisor == 1) {
            var advisor_cat_id_div = document.getElementById("advisor_cat_id_div");
            advisor_cat_id_div.style.display = "block"
        }
        if (digital_guide_subscription_value == 1) {
            $('#digital_guide_subscription_from_to_div').removeClass('d-none')
        }
        if (other_city == 0) {
            $('#other_city_dev').removeClass('d-none')
        }

        if (lawyer_type == 1) {
            $('#company_name_div').css('display', 'none');
            $('#lisences_div').css('display', 'none');
            $('#other_entity_name_div').css('display', 'none');
            $('#cv_div').css('display', 'block');
        } else if (lawyer_type == 2 || lawyer_type == 3) {
            $('#company_name_div').css('display', 'block');
            $('#lisences_div').css('display', 'block');
            $('#other_entity_name_div').css('display', 'none');
            $('#cv_div').css('display', 'none');

        } else if (lawyer_type == 4 || lawyer_type == 5 || lawyer_type == 6) {
            $('#company_name_div').css('display', 'none');
            $('#lisences_div').css('display', 'none');
            $('#other_entity_name_div').css('display', 'block');
            $('#cv_div').css('display', 'none');

        }


    })

    $('#country_id_select').on('change', function (e) {
        e.preventDefault();
        let country_id = $(this).val();
        let actionUrl = '{{route('admin.digital-guide.get-regions-bade-country-id')}}' + '/' + country_id;
        $.get(actionUrl, function (response) {
            if (response.status) {
                $('#region_id_select').html(response.items_html);
            }
        });
    })
    $('#region_id_select').on('change', function (e) {
        e.preventDefault();
        let region_id = $(this).val();
        let actionUrl = '{{route('admin.digital-guide.get-cities-bade-region-id')}}' + '/' + region_id;
        $.get(actionUrl, function (response) {
            if (response.status) {
                $('#city_id_select').html(response.items_html);
            }
        });
    });

    $('#city_id_select').on('change', function (e) {
        e.preventDefault();
        let district_select_id = $(this).val();
        let actionUrl = '{{route('admin.digital-guide.get-districts-bade-city-id')}}' + '/' + district_select_id;
        $.get(actionUrl, function (response) {
            if (response.status) {
                $('#district_id_select').html(response.items_html);
            }
        });
    });

    $('#identity_type_select').on('change', function (e) {
        e.preventDefault();
        let value = $(this).val();
        let status = '{{$lawyer->identity_type}}'
        var other_idetity_type_dev = document.getElementById("other_idetity_type_dev");
        if (value == 4) {
            other_idetity_type_dev.style.display = "block"
        } else {
            other_idetity_type_dev.style.display = "none"
        }
    })
    $('#degree_select').on('change', function () {
        let value = $(this).val();
        var other_degree_dev = document.getElementById("other_degree_dev");
        if (value == 4) {
            if (other_degree_dev.style.display === "none") {
                other_degree_dev.style.display = "block";
            } else {
                other_degree_dev.style.display = "none";
            }
        } else {
            if (other_degree_dev.style.display === "none") {
                // div.style.display = "block";
            } else {
                other_degree_dev.style.display = "none";
            }
        }
    });
    $('#has_licence_no_select').on('change', function () {
        let value = $(this).val();
        var licence_no_dev = document.getElementById("licence_no_dev");
        if (value == 1) {
            if (licence_no_dev.style.display === "none") {
                licence_no_dev.style.display = "block";
            } else {
                licence_no_dev.style.display = "none";
            }
        } else {
            if (licence_no_dev.style.display === "none") {
                // div.style.display = "block";
            } else {
                licence_no_dev.style.display = "none";
            }
        }
    });
    $('#is_advisor_select').on('change', function () {
        let is_advisor_value = $(this).val();
        var advisor_cat_id_div = document.getElementById("advisor_cat_id_div");
        if (is_advisor_value == 1) {
            if (advisor_cat_id_div.style.display === "none") {
                advisor_cat_id_div.style.display = "block";
            } else {
                advisor_cat_id_div.style.display = "none";
            }
        } else {
            if (advisor_cat_id_div.style.display === "none") {
            } else {
                advisor_cat_id_div.style.display = "none";
            }
        }
    });
    $('#digital_guide_subscription_select').on('change', function () {
        let digital_guide_subscription_value = $(this).val();

        var digital_guide_subscription_from_to_div = $('#digital_guide_subscription_from_to_div');
        if (digital_guide_subscription_value == 1 && digital_guide_subscription_value.length == 1) {
            if (digital_guide_subscription_from_to_div.hasClass('d-none')) {
                digital_guide_subscription_from_to_div.removeClass('d-none');
            }
        } else if (digital_guide_subscription_value == 0 && digital_guide_subscription_value.length == 1) {
            if (digital_guide_subscription_from_to_div.hasClass('d-none') == false) {
                digital_guide_subscription_from_to_div.addClass('d-none');
            }
        } else {
            if (digital_guide_subscription_from_to_div.hasClass('d-none') == false) {
                digital_guide_subscription_from_to_div.addClass('d-none');
            }


        }
    });
    $('#city_id_select').on('change', function () {
        let city_id_value = $(this).val();
        console.log(city_id_value);
        if (city_id_value == 0) {
            $('#other_city_dev').removeClass('d-none');
        } else {
            if ($('#other_city_dev').hasClass('d-none') == false) {
                $('#other_city_dev').addClass('d-none');
            }

        }
    });

    $('#type_select').on('change', function () {
        let type_select_value = $(this).val();
        if (type_select_value == 1) {
            $('#company_name_div').css('display', 'none');
            $('#lisences_div').css('display', 'none');
            $('#other_entity_name_div').css('display', 'none');
            $('#cv_div').css('display', 'block');
        } else if (type_select_value == 2 || type_select_value == 3) {
            $('#company_name_div').css('display', 'block');
            $('#lisences_div').css('display', 'block');
            $('#other_entity_name_div').css('display', 'none');
            $('#cv_div').css('display', 'none');
        } else if (type_select_value == 4 || type_select_value == 5 || type_select_value == 6) {
            $('#company_name_div').css('display', 'none');
            $('#lisences_div').css('display', 'none');
            $('#cv_div').css('display', 'none');
            $('#other_entity_name_div').css('display', 'block');
        }

    });


    function initMap() {
        var myLatlng = new google.maps.LatLng('{{$lawyer->latitude}}', '{{$lawyer->longitude}}');
        var myOptions = {
            zoom: 10,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
        var geocoder = new google.maps.Geocoder();
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            draggable: true,
            title: "Drag me!"
        });
        marker.addListener('dragend', function (event) {
            $('#lat').val(event.latLng.lat());
            $('#lon').val(event.latLng.lng());
            geocoder.geocode({
                'latLng': event.latLng
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        //alert(results[0].formatted_address);
                        $('#Settings_address').val(results[0].formatted_address);
                    }
                }
            });

        });


        google.maps.event.addListener(map, 'click', function (event) {
            geocoder.geocode({
                'latLng': event.latLng
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        alert(results[0].formatted_address);
                    }
                }
            });
        });
    }
    // form repeater jquery
    $('.repeater-sections').repeater({

        show: function () {
            $(this).slideDown();
            // Feather Icons
            if (feather) {
                feather.replace({ width: 14, height: 14 });
                $(this).find('select').next('.select2-container').remove();
                $(this).find('select').select2();
            }
        },
        hide: function (deleteElement) {
            if (confirm('هل انت متأكد من حذف العنصر ؟')) {
                $(this).slideUp(deleteElement);
            }
        }
    });

    $(document).on('click', '.btn-delete-lawyer-section', function (e) {
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
                confirmButton: "btn btn-primary confirm_btn_lawyer_section",
                cancelButton: "btn btn-outline-danger ms-1"
            },
            buttonsStyling: !1
        });
        $('.confirm_btn_lawyer_section').on('click', function (t) {
            t.preventDefault();
            $.ajax({
                url: actionUrl,
                type: 'get',
                success: function (response) {
                    $('#LawyerSectionsTable #btn_delete_lawyer_section_' + pid).closest('tr').css('background', '#714f4f').delay(500).hide(500);
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

</script>
<script src="{{asset('admin/app-assets/js/scripts/pages/page-account-settings-account.js')}}"></script>
