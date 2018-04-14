<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home - PDRRMO Bulacan')</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{URL::to('css/app.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/home.css')}}">
    @yield('styles')
  </head>
  <body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-desktop-drawer-button" id="app">
    <header class="mdl-layout__header background fat-header no-shadow">
      <div class="mdl-layout__header-row">
        <!-- Title -->
        <span class="mdl-layout-title mdl-color-text--white logo">PDRRMO  Bulacan</span>
        <!-- Add spacer, to align navigation to the right -->
        <div class="mdl-layout-spacer"></div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation mdl-layout--large-screen-only nav">
          <a class="mdl-navigation__link mdl-color-text--white" href="{{route('home')}}">Home</a>
          <a class="mdl-navigation__link mdl-color-text--white" href="{{route('about')}}">About</a>
          <a class="mdl-navigation__link mdl-color-text--white" href="{{route('contacts')}}">Contacts</a>
          <a class="mdl-navigation__link mdl-color-text--white" href="{{route('report')}}">Report</a>
        </nav>
      </div>
    </header>
    <div class="mdl-layout__drawer">
      <span class="mdl-layout-title mdl-color-text--grey-900">PDRRMO Bulacan</span>
      <nav class="mdl-navigation">
          <a class="mdl-navigation__link mdl-color-text--grey-900" href="{{route('home')}}">Home</a>
          <a class="mdl-navigation__link mdl-color-text--grey-900" href="{{route('about')}}">About</a>
          <a class="mdl-navigation__link mdl-color-text--grey-900" href="{{route('contacts')}}">Contacts</a>
          <a class="mdl-navigation__link mdl-color-text--grey-900" href="{{route('report')}}">Report</a>
      </nav>
    </div>
    <main class="mdl-layout__content content-color">
      <div class="page-content">
        @yield('details')
      </div>
        <footer class="mdl-mega-footer">
          <p class="mdl-typography--text-center footer-text--size">
          Capstone Project II 
          </p>
          <p class="mdl-typography--text-center footer-text--size">
          All Rights Reserved 2017 
          </p>
          <p class="mdl-typography--text-center footer-text--size">
          &copy; RRO | GVG | RPS
          </p>
      </footer>
    </main>

  </div>
  </body>
  <!--[if lt IE 8]>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <script async defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    @yield('scripts')
</html>