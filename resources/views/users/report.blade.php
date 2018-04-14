@extends('layouts.home')
  @section('title', 'Report - PDRRMO Bulacan')
  @section('details')
    <router-view></router-view>
  @endsection

  @section('scripts')
    <script async defer src="{{URL::to('js/console.js')}}" type="text/javascript"></script>
  @endsection