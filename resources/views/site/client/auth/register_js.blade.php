<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdhYBtJu-w2JmuMNQDZsmXIHRkj8uGQhw&callback&callback=initMap&amp;language=ar-AR">
</script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const emailError = document.getElementsByClassName('client_register_email_error');
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
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



        togglePasswordButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.text = '<span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>';
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.text = '<span class="adon-icon"><span class="fa fa-unlock-alt"></span></span>';
            }
        });
    });


    $('#phone_code').on('change', function () {
        let value = $(this).val();
        if(value == 966){
            $('#mobile').attr('maxLength',9);
        }else {
            $('#mobile').attr('maxLength',10);
        }
    });



    function initMap() {
        var myLatlng = new google.maps.LatLng(30.0444, 31.2357);
        var myOptions = {
            zoom: 10,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById("client-map-canvas"), myOptions);
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

    $('#country_select').on('change', function () {
        let country_id = $(this).val();
        let actionUrl = '{{route('site.lawyer.get-regions-bade-country-id')}}' + '/' + country_id;
        let region_id;
        let city_id;
        $.get(actionUrl, function (response) {
            if (response.status) {
                $('#region_id').html(response.items_html);
            }
            if (response.first_region != null) {
                region_id = response.first_region.id;
            } else {
                region_id = 0;
            }
            let actionUrl_region = '{{route('site.client.get-cities-bade-country-id')}}' + '/' + region_id;
            $.get(actionUrl_region, function (response) {
                if (response.status) {
                    $('#city').html(response.items_html);
                }
            });

        });

    });
    $('#region_id').on('change', function () {
        let region_id = $(this).val();
        let actionUrl = '{{route('site.lawyer.get-cities-bade-region-id')}}' + '/' + region_id;
        $.get(actionUrl, function (response) {
            if (response.status) {
                $('#city').html(response.items_html);
            }
        });
    });


    function getFormInputs(formId) {
        return new FormData(formId[0]);
    }

    function disableAndLoadingButton(selector, loadingText) {
        selector.attr('disabled', true).html('<div class="fa fa-spinner fa-spin"></div> ' + loadingText);
    }

    function enableAndLoadingButton(selector, normalText) {
        selector.attr('disabled', false).html(normalText);
    }

    $('#client-registration').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = getFormInputs(form);
        let actionUrl = form.attr('action');
        $btn = $('#save_client_btn');
        $.ajax({
            url: actionUrl,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                disableAndLoadingButton($btn, "جاري الحفظ..");
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
                }
            },
            error: function (error) {
                enableAndLoadingButton($btn, "سجل هنا");
                console.log(error.responseJSON.errors);
                Swal.fire(
                    '  خطأ !',
                    'هناك بعض الاخطاء في البيانات  !',
                    'error'
                ).then(function () {
                    $.each(error.responseJSON.errors, function (key, value) {
                        $('.client_register_' + key + '_error').text(value);
                    });
                })


            }
        });

    })
</script>
