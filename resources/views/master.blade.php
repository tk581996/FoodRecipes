<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>FoodRecipes</title>
  <!-- Main css -->
  <link href="css/main.scss" rel="stylesheet">
  <!-- Including a css file in a blade template -->
  @stack('styles')
  @stack('scripts')
  <!-- Template css -->
  <link href="source/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="source/css/modern-business.css" rel="stylesheet">
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
  <script src="source/vendor/jquery/jquery.min.js"></script>
  <script src="source/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Including a scripts file in a blade template -->
  @stack('scripts')
</body>

</html>