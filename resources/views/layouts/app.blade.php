<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
</head>
@yield('styles')
<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
			rel="stylesheet">
	<link rel="stylesheet" href="{{URL::to('css/app.css')}}">
<body>
	<div id="app">
	@yield('content')
	</div>
</body>
<!--[if lt IE 8]>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->
  <!--[if lt IE 8]>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	@yield('scripts')
</html>