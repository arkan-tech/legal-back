$(function () {
    ('use strict');

    // variables
    var form = $('.validate-form'),
        accountUploadImg = $('#account-upload-img'),
        accountUploadBtn = $('#account-upload'),
        accountUserImage = $('.uploadedAvatar'),
        accountResetBtn = $('#account-reset'),

        accountUploadLicenseFile = $('#account-upload-LicenseFile'),
        LicenseFileUploadBtn = $('#LicenseFile-upload'),
        LicenseFileUserImage = $('.uploadedLicenseFile'),
        LicenseFileResetBtn = $('#LicenseFile-reset'),

        accountUploadIdFile = $('#account-upload-IdFile'),
        IdFileUploadBtn = $('#IdFile-upload'),
        accountUserIdFile = $('.uploadedIdFile'),
        IdFileResetBtn = $('#IdFile-reset'),

        accountUploadLogo = $('#account-upload-logo'),
        accountUploadLogoBtn = $('#account-upload-logo-btn'),
        accountResetLogoBtn = $('#account-reset-logo'),
        accountLogoImage = $('.uploadedLogo'),

        accountNumberMask = $('.account-number-mask'),
        accountZipCode = $('.account-zip-code'),
        select2 = $('.select2');
    // deactivateAcc = document.querySelector('#formAccountDeactivation'),
    // deactivateButton = deactivateAcc.querySelector('.deactivate-account');

    // Update user photo on click of button

    if (accountUserImage) {
        var resetImage = accountUserImage.attr('src');
        accountUploadBtn.on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (accountUploadImg) {
                    accountUploadImg.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });

        accountResetBtn.on('click', function () {
            accountUserImage.attr('src', resetImage);
        });
    }
    if (accountLogoImage) {
        var resetLogo = accountLogoImage.attr('src');
        accountUploadLogoBtn.on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (accountUploadLogo) {
                    accountUploadLogo.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });
        accountResetLogoBtn.on('click', function () {
            accountUploadLogo.attr('src', resetLogo);
        });
    }
    if (accountUserIdFile) {

        var resetIdFile = accountUserIdFile.attr('src');

        IdFileUploadBtn.on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (accountUserIdFile) {
                    accountUserIdFile.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });

        IdFileResetBtn.on('click', function () {
            accountUploadIdFile.attr('src', resetIdFile);
        });
    }




    if (LicenseFileUserImage) {
        var resetLicenseFile = accountUploadLicenseFile.attr('src');
        LicenseFileUploadBtn.on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (accountUploadLicenseFile) {
                    accountUploadLicenseFile.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });

        LicenseFileResetBtn.on('click', function () {
            accountUploadLicenseFile.attr('src', resetLicenseFile);
        });
    }
    // jQuery Validation for all forms
    // --------------------------------------------------------------------



    // Deactivate account alert
    const accountActivation = document.querySelector('#accountActivation');


    //phone
    if (accountNumberMask.length) {
        accountNumberMask.each(function () {
            new Cleave($(this), {
                phone: true,
                phoneRegionCode: 'US'
            });
        });
    }

    //zip code
    if (accountZipCode.length) {
        accountZipCode.each(function () {
            new Cleave($(this), {
                delimiter: '',
                numeral: true
            });
        });
    }

    // For all Select2
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                dropdownParent: $this.parent()
            });
        });
    }
});
