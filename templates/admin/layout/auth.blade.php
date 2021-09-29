<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<!-- BEGIN: Head-->
@include('admin.layout.head')
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Page Vendor JS-->
    @include('admin.layout.script')
    <!-- END: Page Vendor JS-->
</body>
<!-- END: Body-->

</html>