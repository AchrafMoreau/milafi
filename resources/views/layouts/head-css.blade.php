@yield('css')
<!-- Layout config Js -->
<script src="{{ URL::asset('build/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<!-- Icons Css -->
<link href="{{ URL::asset('build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

<!-- App Css-->
<!-- custom Css-->
@if(app()->getLocale() === 'ae')
    <link href="{{ URL::asset('build/css/app-rtl.min.css') }}?v={{ time() }}" id="app-style-rtl" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/css/bootstrap-rtl.min.css') }}?v={{ time() }}" id="bootstrap-style-rtl" rel="stylesheet" type="text/css" />
@else
    <link href="{{ URL::asset('build/css/app.min.css') }}?v={{ time() }}" id="app-style-ltr" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/css/bootstrap.min.css') }}?v={{ time() }}" id="bootstrap-style-ltr" rel="stylesheet" type="text/css" />
@endif
<link href="{{ URL::asset('build/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
{{-- @yield('css') --}}