@extends('layouts.app')
  @section('title', 'Administrator - PDRRMO Bulacan')
  @section('styles')
  <link rel="stylesheet" href="{{URL::to('css/vendor.css')}}">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  @endsection
  @section('content')
  <!-- Always shows a header, even in smaller screens. -->
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
      <div class="mdl-layout__header-row">
        <!-- Title -->
        <span class="mdl-layout-title">PDRRMO Bulacan</span>
        <!-- Add spacer, to align navigation to the right -->
        <div class="mdl-layout-spacer"></div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation">
          <tides-notifications></tides-notifications>
          <messages-notifications></messages-notifications>
          <rescuer-notifications></rescuer-notifications>
          <p style="display:none">@{{datenow}}</p>
          {{--  notifications  --}}
          <button id="demo-menu-lower-right"
                  class="mdl-button mdl-js-button mdl-button--icon">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
              for="demo-menu-lower-right">
            <li class="mdl-menu__item">{{ Auth::user()->name }}</li>
            <li class="mdl-menu__item" id="municipalOffice" style="display:none;" ref="theMunicipality">{{ Auth::user()->municipality }}</li>
            <li class="mdl-menu__item" id="municipalAddress" style="display:none;">{{ Auth::user()->municipalAddress }}</li>
            <li class="mdl-menu__item"><a href="{{route('logout')}}">Logout</a></li>
          </ul>
        </nav>
      </div>
      
    </header>
    <div class="mdl-layout__drawer long">
      <span class="mdl-layout-title">PDRRMO Bulacan</span>
      <nav class="mdl-navigation">
      @if (Auth::user()->municipality == 'Bulacan' ||  Auth::user()->municipality == 'Administrator')
        <router-link to="/administrator" class="mdl-navigation__link"><i class="material-icons padding">report</i>Reports</router-link>
        <router-link to="/weather" class="mdl-navigation__link"><i class="material-icons padding">&#xE430;</i>Weather Update</router-link>
        <router-link to="/tides" class="mdl-navigation__link"><i class="material-icons padding">pool</i>Tides</router-link>
        <router-link to="/settings" class="mdl-navigation__link"><i class="material-icons padding">&#xE8B8;</i>Access Control</router-link>
      @endif
      @unless(Auth::user()->municipality == 'Bulacan' ||  Auth::user()->municipality == 'Administrator' ||
      Auth::user()->municipality == 'Angat Dam' ||  Auth::user()->municipality == 'Ipo Dam' || Auth::user()->municipality == 'Bustos Dam')
       <router-link to="/administrator" class="mdl-navigation__link"><i class="material-icons padding">report</i>Reports</router-link>
      @endunless
        <router-link to="/teams" class="mdl-navigation__link"><i class="material-icons padding">&#xE145;</i>Add Team Leads</router-link>
        <router-link to="/assign" class="mdl-navigation__link"><i class="material-icons padding">&#xE8D3;</i>Set Team Leads</router-link>
        <router-link to="/chat" class="mdl-navigation__link"><i class="material-icons padding">message</i>Chat</router-link>
      </nav>
    </div>
    <main class="mdl-layout__content custom--color">
      <div class="page-content">
        <router-view v-bind="{allMessages, allUsers, barangays}"></router-view>
      </div>
    </main>
  </div>
  @endsection
  @section('scripts')
    <script async defer src="https://cdn.polyfill.io/v2/polyfill.min.js?features=Array.prototype.find,Intl"></script>
    <script async defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script async defer src="{{URL::to('js/vendor.js')}}"></script>
    <script async defer src="{{URL::to('js/app.js')}}"></script>
  @endsection