<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="http://icons.iconarchive.com/icons/webalys/kameleon.pics/512/Food-Dome-icon.png">

  <title>FoodRecipes</title>
  <!-- Main css -->
  {{ HTML::style('css/main.css')}}
  <!-- Template css -->
  {{ HTML::style('source/vendor/bootstrap/css/bootstrap.min.css') }}
  {{ HTML::style('source/css/modern-business.css') }}
  <!-- Including a css file in a blade template -->
  <link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP&display=swap&subset=japanese" rel="stylesheet">
  {{ HTML::style('fontawesome/css/all.css') }}
  @stack('styles')
  @stack('scripts')
</head>

<body>

  <!-- Navigation -->
  @include("navbar")

  <!-- Page Content -->
  @yield("content")
  <!-- /.container -->

  <!-- Footer -->
  @include("footer")

  <!-- JS template -->
  {{ HTML::script('source/vendor/jquery/jquery.min.js')}}
  {{ HTML::script('source/vendor/bootstrap/js/bootstrap.bundle.min.js')}}
  <!-- Including a scripts file in a blade template -->
  @stack('scripts')
</body>

</html>