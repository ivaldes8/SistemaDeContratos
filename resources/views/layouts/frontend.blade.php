<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema de contratos</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap5.css') }}"/>
        <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}"/>
        <!--<script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>-->
        <script src="{{ asset('frontend/js/ajaxjquery.js') }}"></script>
        <script src="{{ asset('frontend/js/ajaxpropper.js') }}"></script>
        <script src="{{asset('frontend/js/bootstrap5.bundle.js')}}"></script>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
            <div>
                @include('layouts.inc.navbar')
                @yield('content')
            </div>
    </body>
</html>
