<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- page title -->
    <title>{{ strtoupper( $appName )  }}</title>
    <!-- /page title -->

    <!-- css assets -->
    <link rel="stylesheet" type="text/css" href="{{ url( 'css/bootstrap.min.css' ) }} ">
    <link rel="stylesheet" type="text/css" href="{{ url( 'css/fontawesome-all.min.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ url( $assetsRootFolder . 'css/iofrm-style.css' ) }}?{{ $refresh_id }}">
    <link rel="stylesheet" type="text/css" href="{{ url( $assetsRootFolder . 'css/iofrm-theme10.css' ) }}?{{ $refresh_id }}">
    <!-- css assets -->
</head>
<body style="background-color: #57cba6cc;">

<!-- TODO : ADD CLASS APPEAR Dynamically with JS -->
<div id="main-content" class="appear">
    @yield('content')
</div>

<!-- js assets -->
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/popper.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<!-- /js assets -->

<!-- main js code -->
<script src="{{ url( $assetsRootFolder . 'js/main.js') }}?{{ $refresh_id }}"></script>

</body>
</html>