<!-- BEGIN: Vendor JS-->
<script src="{{asset('admin/app-assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('admin/app-assets/js/scripts/forms/form-select2.js')}}"></script>
<script src="{{asset('admin/app-assets/js/scripts/forms/form-number-input.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('admin/app-assets/js/scripts/extensions/ext-component-sweet-alerts.min.js')}}"></script>
<script src="{{asset('admin/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('admin/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('admin/app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('admin/app-assets/js/core/app.js')}}"></script>
<!-- END: Theme JS-->

@yield('scripts')
<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });

    var baseUrl = @json(url('/'));
    function getFormInputs(formId) {
        return new FormData(formId[0]);
    }

    ClassicEditor
        .create( document.querySelector( '.ck_editor' ), {
            language: 'ar'
        } )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
