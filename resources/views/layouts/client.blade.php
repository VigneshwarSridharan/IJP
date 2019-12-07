<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ url('storage/'.setting('site.logo') )}}" sizes="16x16" type="image/png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('/css/fonts.css')}}">
    <link rel="stylesheet" href="{{url('/css/app.css')}}">
    <link rel="stylesheet" href="{{url('/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('/css/lib/animate.css')}}">
    @stack('styles')

    <title>{{ setting('site.title')}}</title>
  </head>
  <body>
    @include('components.navigation')
    @yield('content')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.4.1.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    @stack('scripts')

  </body>
</html>