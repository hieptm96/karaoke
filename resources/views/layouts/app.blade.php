
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="/vendor/ubold/assets/images/favicon_1.ico">

    <title>{{ config('app.name') }}</title>

    @stack('styles')

    <link href="/vendor/ubold/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/css/responsive.css" rel="stylesheet" type="text/css" />

    @stack('inline_styles')

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="/vendor/ubold/assets/js/modernizr.min.js"></script>

</head>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    @include('common.header')
    <!-- Top Bar End -->

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        @include('common.menu')
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                @yield('content')
            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer">
            © @php date('Y') @endphp. All rights reserved.
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

    <!-- Right Sidebar -->
    <!-- /Right-bar -->

</div>
<!-- END wrapper -->

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="/vendor/ubold/assets/js/jquery.min.js"></script>
<script src="/vendor/ubold/assets/js/bootstrap.min.js"></script>
<script src="/vendor/ubold/assets/js/detect.js"></script>
<script src="/vendor/ubold/assets/js/fastclick.js"></script>
<script src="/vendor/ubold/assets/js/jquery.slimscroll.js"></script>
<script src="/vendor/ubold/assets/js/jquery.blockUI.js"></script>
<script src="/vendor/ubold/assets/js/waves.js"></script>
<script src="/vendor/ubold/assets/js/wow.min.js"></script>
<script src="/vendor/ubold/assets/js/jquery.nicescroll.js"></script>
<script src="/vendor/ubold/assets/js/jquery.scrollTo.min.js"></script>

@stack('scripts')

<script src="/vendor/ubold/assets/js/jquery.core.js"></script>
<script src="/vendor/ubold/assets/js/jquery.app.js"></script>

@stack('inline_scripts')

</body>
</html>