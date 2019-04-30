<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="theme-color" content="#000000">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ovac4u...</title>
    </head>
    <body>
        <div id="root"></div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
