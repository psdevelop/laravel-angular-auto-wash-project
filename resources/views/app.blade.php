<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link rel="icon" type="image/png" href="{{url('/')}}/img/cm_favicon.png">
  <link href="{{url('/')}}/twtrbootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="{{url('/')}}/js/jquery/jquery.min.js"></script>
  <script src="{{url('/')}}/twtrbootstrap/js/bootstrap.js"></script>
  <link href="{{url('/')}}/css/custom.css" rel="stylesheet">
  @yield('customcss')
  @yield('customjs')
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  @include('nav')
  @yield('content')
</body>
</html>
