
<script src="{{asset('site/js/popper.min.js')}}"></script>
<script src="{{asset('site/js/bootstrap.min.js')}}"></script>
<script src="{{asset('site/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('site/js/jquery.fancybox.js')}}"></script>
<script src="{{asset('site/js/appear.js')}}"></script>
<script src="{{asset('site/js/nav-tool.js')}}"></script>
<script src="{{asset('site/js/mixitup.js')}}"></script>
<script src="{{asset('site/js/owl.js')}}"></script>
<script src="{{asset('site/js/wow.js')}}"></script>
<script src="{{asset('site/js/isotope.js')}}"></script>
<script src="{{asset('site/js/jquery-ui.js')}}"></script>
<script src="{{asset('site/js/script.js')}}"></script>
<script src="{{asset('site/js/color-settings.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#sections').select2({
        width: '100%',
        placeholder: "المهن",
        allowClear: true
    });
    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false,
            width: '100%',
        });

    });
</script>

<script>
    $.ajaxSetup({
        'headers':{
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    function getFormInputs(formId) {
        return new FormData(formId[0]);
    }
</script>
<script src="{{asset('site/js/jquery-repeater/jquery.repeater.js')}}"></script>
<script src="{{asset('site/js/jquery-repeater/form-repeater.min.js')}}"></script>

@yield('site_scripts')
