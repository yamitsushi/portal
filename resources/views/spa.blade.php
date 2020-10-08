<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  <link
      href="{{ asset("css/materialdesignicons/materialdesignicons.min.css"); }}"
      rel="stylesheet"
  />
</head>
<body>
  <div id="app">
    <h1 style="text-align: center;">Please Enable Javascript</h1>
  </div>
  <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>