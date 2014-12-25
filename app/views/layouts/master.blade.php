<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]>
<html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- start: HEAD -->
<head>
    <title>@yield('title')</title>
    <!-- start: META -->
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- end: META -->
    <!-- start: MAIN CSS -->
    <link href="http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,200,100,800" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/iCheck/skins/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles-responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/themes/theme-style4.css')}}" type="text/css" id="skin_color">
    <link rel="stylesheet" href="{{asset('assets/css/print.css')}}" type="text/css" media="print"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="{{asset('assets/plugins/font-awesome/css/font-awesome-ie7.min.css')}}">
    <![endif]-->
    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    @yield('extraCSS')
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
</head>
<!-- end: HEAD -->
<!-- start: BODY -->

@yield('body')

<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
<script src="{{asset('assets/plugins/respond.min.js')}}"></script>
<script src="{{asset('assets/plugins/excanvas.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/plugins/jQuery/jquery-1.11.1.min.js')}}"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script src="{{asset('assets/plugins/jQuery/jquery-2.1.1.min.js')}}"></script>
<!--<![endif]-->
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/plugins/blockUI/jquery.blockUI.js')}}"></script>
<script src="{{asset('assets/plugins/iCheck/jquery.icheck.min.js')}}"></script>
<script src="{{asset('assets/plugins/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js')}}"></script>
<script src="{{asset('assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/plugins/bootbox/bootbox.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.scrollTo/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('assets/plugins/ScrollToFixed/jquery-scrolltofixed-min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.appear/jquery.appear.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-cookie/jquery.cookie.js')}}"></script>
<script src="{{asset('assets/plugins/velocity/jquery.velocity.min.js')}}"></script>
<script src="{{asset('assets/plugins/TouchSwipe/jquery.touchSwipe.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
@yield('extraJS')
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
</body>
<!-- end: BODY -->
</html>