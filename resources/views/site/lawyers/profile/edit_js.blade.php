<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdhYBtJu-w2JmuMNQDZsmXIHRkj8uGQhw&callback&callback=initMap&amp;language=ar-AR">
</script>
<script>



    document.addEventListener('DOMContentLoaded', function () {
        // Get the form repeater container
        const repeaterContainer = document.getElementById('repeaterForm');
        // Get the first item in the repeater
        const firstFormGroup = repeaterContainer.querySelector('.form-group:first-child');
        const deleteButton = firstFormGroup.querySelector('.mt-repeater-delete');
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        togglePasswordButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.text = '<span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>';
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.text = '<span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>';
            }
        });
        const emailInput = document.getElementById('email');
        const emailError = document.getElementsByClassName('client_register_email_error');

        emailInput.addEventListener('input', function(event) {
            const enteredText = event.target.value;
            const isValid = isEnglish(enteredText);

            if (!isValid) {
                emailInput.value = removeNonEnglishCharacters(enteredText);
                emailError.textContent = 'الرجاء ادخال احرف انجليزية فقط.';
            } else {
                emailError.textContent = '';
            }
        });

        function isEnglish(text) {
            return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(text);
        }

        function removeNonEnglishCharacters(text) {
            return text.replace(/[^a-zA-Z0-9._%+-@]/g, '');
        }
        // deleteButton.remove();
        let lawyer_type = '{{$lawyer->type}}';
        if (lawyer_type == 1) {
            $('#div_company_lisences_no').css('display', 'none');
            $('#div_company_lisences_file').css('display', 'none');
            $('#div_company_name').css('display', 'none');
            $('#div_cv').css('display', 'block');
        } else if (lawyer_type == 3 || lawyer_type == 2) {
            $('#div_company_lisences_no').css('display', 'block');
            $('#div_company_lisences_file').css('display', 'block');
            $('#div_cv').css('display', 'none');
            $('#div_company_name').css('display', 'none');
        } else if (lawyer_type == 4 || lawyer_type == 5 || lawyer_type == 6) {
            $('#div_company_lisences_no').css('display', 'none');
            $('#div_company_lisences_file').css('display', 'none');
            $('#div_company_name').css('display', 'block');
            $('#div_cv').css('display', 'none');
        }

            let identity_type_1 =  '{{$lawyer->identity_type}}';
            let nat_id = $('#nat_id');
            if (identity_type_1 == 2) {
                nat_id.attr('type', 'text');
                nat_id.removeAttr('pattern');
            } else {
                nat_id.attr('type', 'number');
                nat_id.attr('pattern', '[0-9]');

            }
    });

    function toggleElementsVisibility(selectElement) {
        const selectedValue = selectElement.value;
        const parentFormGroup = selectElement.closest('.form-group');

        // Hide all elements with class 'text-input'
        const textInputs = parentFormGroup.querySelectorAll('.hide-inputs');

        let actionUrl = '{{route('site.lawyer.check.section')}}' + '/' + selectedValue;

        $.get(actionUrl, function (response) {
            if (response.section.need_license == 1) {
                textInputs.forEach(function (input) {
                    input.style.display = 'block';
                });
            } else {
                textInputs.forEach(function (input) {
                    input.style.display = 'none';
                });
            }

        });

    }

    // Add event listeners to all select inputs in the repeater
    const selectInputs = document.querySelectorAll('.select-input');
    selectInputs.forEach(function (selectInput) {
        selectInput.addEventListener('change', function () {
            toggleElementsVisibility(this);
        });
    });



    function toggleElementsVisibilityUpdateSection(selectElement) {
        const selectedValueUpdate = selectElement.value;
        const parentFormGroupUpdate = selectElement.closest('.form-group');

        // Hide all elements with class 'text-input'
        const textInputsUpdate = parentFormGroupUpdate.querySelectorAll('.update-section-hide-inputs');
        let actionUrlUpdate = '{{route('site.lawyer.check.section')}}' + '/' + selectedValueUpdate;

        $.get(actionUrlUpdate, function (response) {
            if (response.section.need_license == 1) {
                textInputsUpdate.forEach(function (input) {
                    input.style.display = 'block';
                    $('#edit_section_form #licence_no').attr('required','required');
                    $('#edit_section_form #licence_file').attr('required','required');
                });
            } else {
                textInputsUpdate.forEach(function (input) {
                    input.style.display = 'none';
                    $('#edit_section_form #licence_no').removeAttr('required');
                    $('#edit_section_form #licence_file').removeAttr('required');

                });
            }

        });

    }

    // Add event listeners to all select inputs in the repeater
    const selectInputsUpdate = document.querySelectorAll('.select-input');
    selectInputsUpdate.forEach(function (selectInput) {
        selectInputUpdate.addEventListener('change', function () {
            toggleElementsVisibilityUpdateSection(this);
        });
    });

    $('#phone_code').on('change', function () {
        let value = $(this).val();
        if (value == 966) {
            $('#phone').attr('maxLength', 9);
        } else {
            $('#phone').attr('maxLength', 10);
        }
    });


    function getFormInputs(formId) {
        return new FormData(formId[0]);
    }

    function licencesfun(event) {
        if (event.target.value == 1) {
            $('#div_company_lisences_no').css('display', 'none');
            $('#div_company_lisences_file').css('display', 'none');
            $('#div_company_name').css('display', 'none');
            $('#div_cv').css('display', 'block');
        } else if (event.target.value == 3 || event.target.value == 2) {
            $('#div_company_lisences_no').css('display', 'block');
            $('#div_company_lisences_file').css('display', 'block');
            $('#div_cv').css('display', 'none');
            $('#div_company_name').css('display', 'none');
        } else if (event.target.value == 4 || event.target.value == 5 || event.target.value == 6) {
            $('#div_company_lisences_no').css('display', 'none');
            $('#div_company_lisences_file').css('display', 'none');
            $('#div_company_name').css('display', 'block');
            $('#div_cv').css('display', 'none');
        }
    }

    $('#country_id').on('change', function () {
        let country_id = $(this).val();
        let actionUrl = '{{route('site.lawyer.get-regions-bade-country-id')}}' + '/' + country_id;
        let region_id;
        let city_id;
        $.get(actionUrl, function (response) {
            if (response.status) {
                $('#region').html(response.items_html);
            }
            if (response.first_region != null) {
                region_id = response.first_region.id;
            } else {
                region_id = 0;
            }
            let actionUrl_region = '{{route('site.lawyer.get-cities-bade-region-id')}}' + '/' + region_id;
            $.get(actionUrl_region, function (response) {
                if (response.status) {
                    $('#city').html(response.items_html);
                }
            });
        });

    });
    $('#region').on('change', function () {
        let region_id = $(this).val();
        let actionUrl = '{{route('site.lawyer.get-cities-bade-region-id')}}' + '/' + region_id;
        $.get(actionUrl, function (response) {
            if (response.status) {
                $('#city').html(response.items_html);
            }
        });
    });


    $('#identity_type').on('change', function () {
        let identity_type = $(this).val();
        let nat_id = $('#nat_id');
        if (identity_type == 2) {
            nat_id.attr('type', 'text');
            nat_id.removeAttr('pattern');
        } else {
            nat_id.attr('type', 'number');
            nat_id.attr('pattern', '[0-9]');

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

    $('#degree').on('change', function () {
        let pid = $(this).val();
        let actionUrl = '{{route('site.lawyer.check.degree')}}' + '/' + pid;
        $.get(actionUrl, function (response) {
            if (response.status) {
                if (response.degree.need_certificate == 1) {
                    $('#div_degree_certificate').css('display', 'block');

                } else {
                    $('#div_degree_certificate').css('display', 'none');

                }

            }
        });
    })

    function licfun(event) {
        var div = document.getElementById("div_LicenceNo");
        if (event.target.value == 'on') {
            // $('#div_other_note').att
            if (div.style.display === "none") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
            // document.getElementById("div_other_note").style.display = "block";
        } else {
            if (div.style.display === "none") {
                // div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    }

    function cityfun(event) {
        var div_city = document.getElementById("dev_city");
        if (event.target.value != 0 || event.target.value == "") {
            div_city.style.display = "none"

        } else {
            div_city.style.display = "block"
        }
    }

    function identityfun(event) {
        var div_city = document.getElementById("div_other_idetity_type");
        if (event.target.value == 4) {
            div_city.style.display = "block"
        } else {
            div_city.style.display = "none"
        }
    }

    function getImage(imageName) {
        var newimage = imageName.replace(/^.*\\/, "")
        $('#display-image').html(newimage);
    }

    function getLogo(logoName) {
        var newlogo = logoName.replace(/^.*\\/, "")
        $('#display-logo').html(newlogo);
    }

    function getIdFileImage(imageName) {
        var newimage = imageName.replace(/^.*\\/, "")
        $('#display_image_id_file').html(newimage);
    }

    function getLicenseFileImage(imageName) {
        var newimage = imageName.replace(/^.*\\/, "")
        $('#display_image_license_file').html(newimage);
    }

    function getCVFileFile(imageName) {
        var newimage = imageName.replace(/^.*\\/, "")
        $('#display_image_cv_file').html(newimage);
    }

    function disableAndLoadingButton(selector, loadingText) {
        selector.attr('disabled', true).html('<div class="fa fa-spinner fa-spin"></div> ' + loadingText);
    }

    function enableAndLoadingButton(selector, normalText) {
        selector.attr('disabled', false).html(normalText);
    }

    var register_form_elemnt_ids = [];
    $input_ids = $('#lawyer-update-form input[id]').map(function () {
        register_form_elemnt_ids.push(this.id);
    }).get();
    $select_ids = $('#lawyer-update-form select[id]').map(function () {
        register_form_elemnt_ids.push(this.id);
    }).get();
    $textarea_ids = $('#lawyer-update-form textarea[id]').map(function () {
        register_form_elemnt_ids.push(this.id);
    }).get();
    $('#lawyer-update-form').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = getFormInputs(form);
        let actionUrl = form.attr('action');
        let $btn = $('#lawyer-update-form-btn');
        $.ajax({
            url: actionUrl,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                disableAndLoadingButton($btn, "جاري التحديث ...");
            },
            success: function (response) {
                if (response.status) {
                    Swal.fire(
                        'تهانينا !',
                        response.msg,
                        'success'
                    ).then(function () {
                        location.href = response.route;
                    })
                } else {
                    Swal.fire(
                        'خطأ !',
                        response.msg,
                        'error'
                    ).then(function () {
                        enableAndLoadingButton($btn, " تحديث البيانات");
                    })
                }
            },
            error: function (error) {
                enableAndLoadingButton($btn, " تحديث البيانات");
                Swal.fire(
                    'خطأ !',
                    'يرجى مراجعة البيانات جيداً ',
                    'error'
                )
                var validation_ids_return = [];
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.lawyer_update_' + key + '_error').text(' خطأ في الحقل ');
                    validation_ids_return.push(key);
                });
                console.log(validation_ids_return);
                console.log(register_form_elemnt_ids);

                $.each(register_form_elemnt_ids, function (key, value) {
                    if (validation_ids_return.includes(value)) {
                        if ($('.lawyer_update_' + value + '_error').hasClass('d-none')) {
                            $('.lawyer_update_' + value + '_error').removeClass('d-none');
                        }
                        $('.lawyer_update_' + value + '_error').text(' خطأ في الحقل ');
                        $('#' + value).addClass('is-invalid');

                    } else {
                        $('.lawyer_update_' + value + '_error').text('').addClass('d-none');
                        $('#' + value).hasClass('is-invalid') ? $('#' + value).removeClass('is-invalid') : $('#' + value).addClass(' ');
                    }


                    if (validation_ids_return.includes('degree_certificate')) {
                        $('#div_degree_certificate').css('display', 'block');
                    }
                    if (validation_ids_return.includes('company_name')) {
                        $('#div_company_name').css('display', 'block');
                    }
                    if (validation_ids_return.includes('company_lisences_no')) {
                        $('#div_company_lisences_no').css('display', 'block');
                    }
                    if (validation_ids_return.includes('company_lisences_file')) {
                        $('#div_company_lisences_file').css('display', 'block');
                    }
                    if (validation_ids_return.includes('other_idetity_type')) {
                        $('#div_other_idetity_type').css('display', 'block');
                    }
                    if (validation_ids_return.includes('licence_no')) {
                        $('#div_LicenceNo').css('display', 'block');
                        $('#toggle').attr('checked', 'checked');
                    }
                })
            }
        });

    })
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


    $(document).on('click', '.btn-edit-lawyer-section', function (e) {
        e.preventDefault();
        let btn = $(this);
        let actionUrl = btn.attr('href');
        let data_id = btn.attr('data-id');
        $.ajax({
            url: actionUrl,
            type: 'get',
            success: function (response) {
                $('#edit_section_form #id').val(response.section.id);
                $('#edit_section_form #update_section_select_input').val(response.section.section.id).change();
                $('#edit_section_form #licence_no').val(response.section.licence_no);
                    if(response.section.section.need_license ==1){
                        $('#edit_section_form #licence_file_a').css('display','block');
                        $('#edit_section_form #licence_file_a').attr('href',response.section.licence_file);
                    }else {
                        $('#edit_section_form #licence_file_a').css('display','none');
                        $('#edit_section_form #licence_file_a').removeAttr('href');
                    }
                $('#edit_section_modal').modal('show');
            }
        })

    })

    $('#edit_cities_form').submit(function (event) {
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
                    text: " تم تعديل معلومات الترخيص بنجاح. ",
                    confirmButtonText: 'موافق',
                    customClass: {confirmButton: "btn btn-success"}
                }).then(function (){

                })
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (key, value) {
                    $('.cities_update_' + key+'_error').text(value);
                });
                $('#edit_cities_modal').modal('show');

            }

        })
    })


</script>
