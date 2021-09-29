<!-- BEGIN: Vendor JS-->
<script src="{{base_url('template/app-assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
@yield('pagescript')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{base_url('template/app-assets/js/core/app-menu.js')}}"></script>
<script src="{{base_url('template/app-assets/js/core/app.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
@yield('script')
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>