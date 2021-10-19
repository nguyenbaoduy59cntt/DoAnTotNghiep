<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Mega Market Viet Nam</title>

    <style>
        .scroll-left {
            height: 50px; 
            /* overflow: hidden; */
            position: relative;
            }
            .scroll-left p {
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0;
            line-height: 50px;
            text-align: center;
            /* Starting position */
            -moz-transform:translateX(100%);
            -webkit-transform:translateX(100%); 
            transform:translateX(100%);
            /* Apply animation to this element */ 
            -moz-animation: scroll-left 10s linear infinite;
            -webkit-animation: scroll-left 10s linear infinite;
            animation: scroll-left 10s linear infinite;
            }
            /* Move it (define the animation) */
            @-moz-keyframes scroll-left {
            0% { -moz-transform: translateX(100%); }
            100% { -moz-transform: translateX(-100%); }
            }
            @-webkit-keyframes scroll-left {
            0% { -webkit-transform: translateX(100%); }
            100% { -webkit-transform: translateX(-100%); }
            }
            @keyframes scroll-left {
            0% { 
            -moz-transform: translateX(100%); /* Browser bug fix */
            -webkit-transform: translateX(100%); /* Browser bug fix */
            transform: translateX(100%); 
            }
            100% { 
            -moz-transform: translateX(-100%); /* Browser bug fix */
            -webkit-transform: translateX(-100%); /* Browser bug fix */
            transform: translateX(-100%); 
            }
            }
    </style>

    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/css/admin.css" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    @include('admin.left-menu')
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                @include('admin.top-nav')
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                @yield('content')
                @include('sweetalert::alert')
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Mega Market Admin design by <a href="https://www.facebook.com/nguyen.baoduy.02071999">Bao Duy Nguyen</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="/vendors/Flot/jquery.flot.js"></script>
    <script src="/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="/vendors/Flot/jquery.flot.time.js"></script>
    <script src="/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="/vendors/moment/min/moment.min.js"></script>
    <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

   
    <!-- alert sweet -->
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <!-- / ket thuc alert -->
    
    <!-- import ckeditor vào -->
    <script src="/libs/ckeditor/ckeditor.js"></script>

    <!-- import ckfinder vào -->
    <script src="/libs/ckfinder/ckfinder.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="/js/admin.js"></script>
</body>
</html>