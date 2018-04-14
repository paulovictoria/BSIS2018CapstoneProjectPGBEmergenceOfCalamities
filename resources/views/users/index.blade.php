@extends('layouts.home')
  @section('styles')
  @endsection
  @section('details')
    <router-view :results="results"></router-view>
  @endsection
  @section('scripts')
    <script async defer src="{{URL::to('js/home.js')}}" type="text/javascript"></script>
  @endsection