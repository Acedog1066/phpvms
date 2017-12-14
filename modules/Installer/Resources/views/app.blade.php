<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/frontend/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/frontend/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>phpvms installer</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
    <!-- CSS Files -->
    <link href="/assets/frontend/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="/assets/frontend/css/now-ui-kit.css" rel="stylesheet"/>
    <link href="/assets/frontend/css/styles.css" rel="stylesheet"/>
    @yield('css')
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-toggleable-md" style="background: #067ec1;">
    <div class="container" style="width: 85%!important;">
        <div class="navbar-translate">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navigation" aria-controls="navigation-index" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
            <p class="navbar-brand text-white" data-placement="bottom" target="_blank">
                <a href="{!! url('/') !!}">
                    <img src="/assets/frontend/img/logo_blue_bg.svg" width="135px" style=""/>
                </a>
            </p>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation"></div>
    </div>
</nav>
<!-- End Navbar -->
<div class="clearfix" style="height: 25px;"></div>
<div class="wrapper">
    <div class="clear"></div>
    <div class="container-fluid" style="width: 85%!important;">
        @yield('content')
    </div>
    <div class="clearfix" style="height: 200px;"></div>
</div>

<script src="/assets/frontend/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="/assets/frontend/js/core/tether.min.js" type="text/javascript"></script>
<script src="/assets/frontend/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/frontend/js/plugins/bootstrap-switch.js"></script>
<script src="/assets/frontend/js/plugins/nouislider.min.js" type="text/javascript"></script>
<script src="/assets/frontend/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="/assets/frontend/js/now-ui-kit.js" type="text/javascript"></script>
<script src="/vendor/select2/dist/js/select2.js"></script>
<script>
    $(document).ready(function () {
        $(".select2").select2();
    });
</script>

@yield('scripts')

</body>
</html>
