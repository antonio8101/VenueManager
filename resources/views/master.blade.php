<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ss-token" content="{{ $session_token }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- page title -->
    <title>{{ strtoupper( $appName )  }}</title>
    <link href="{{mix('css/app.css')}}?{{ $refresh_id }}" rel="stylesheet" type="text/css">
    <link href="{{url('css/fontawesome-all.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /page title -->

</head>
<body>

<div id="main-content" class="appear">
    @yield('content')
</div>

<!-- js assets -->
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/popper.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<!-- /js assets -->

<!-- main js code -->
<script src="{{ mix( 'js/app.js' ) }}?{{ $refresh_id }}"></script>

</body>
</html>