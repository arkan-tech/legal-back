<script src="{{asset('site/electronic_office/js/jquery-3.3.1.js')}}"></script>
<script src="{{asset('site/electronic_office/js/popper.min.js')}}"></script>
<script src="{{asset('site/electronic_office/js/bootstrap.min.js')}}"></script>
<script src="{{asset('site/electronic_office/js/mine.js')}}"></script>
<script src="{{asset('site/electronic_office/css/assets/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('site/electronic_office/css/assets/vendors/highlight.js')}}"></script>
<script src="{{asset('site/electronic_office/css/assets/js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        rtl: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })
</script>
@yield('electronic_office_site_scripts')
