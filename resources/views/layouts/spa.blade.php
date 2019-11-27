@extends('layouts.default')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('css/roboto.css') }}" rel="stylesheet">
    <link href="{{ asset('css/MaterialDesign/css/materialdesignicons.min.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endsection
@section('body')
    <body>
        @yield('content')
        @parent
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
@endsection
