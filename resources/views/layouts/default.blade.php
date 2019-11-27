<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Russel Dave Cruz">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @yield('head')
    </head>
    @section('body')
    @show
</html>
