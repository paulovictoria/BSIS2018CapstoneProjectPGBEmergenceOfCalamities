@extends('layouts.app')
@section('title', 'Forgot Password - PDRRMO Bulacan')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@endsection
@section('content')
  <div class="md-container">
    <div class="md-layout md-gutter md-alignment-center-space-around md-margin">
      <div class="md-layout-item md-gutter md-large-size-40 md-small-size-50 md-xsmall-size-70 md-elevation-1 md-form--padding animated fadeInUp mdl-color--white">
        <form action="{{route('forgot')}}" method="post">
          <p class="md-display-1 mdl-typography--text-center">
            Forgot Password?
          </p>
          <md-field>
            <label>Email Address..</label>
            <md-input name="email"
                      type="email"
                      required></md-input>
          </md-field>
          <div class="md-layout-item">
            <a href="{{route('login')}}" class="mdl-typography--text-left mdl-typography--body">Login</a>
          </div>
          <div class="md-layout-item">
            <a href="{{route('register')}}" class="mdl-typography--text-left mdl-typography--body">Register!</a>
          </div>
          <div class="md-layout md-float__right">
            <md-button  class="md-dense md-raised md-primary" type="submit">Submit</md-button>
          </div>
          <input type="hidden" value="{{Session::token()}}" name="_token">
        </form>
				@if (Session::has('errors'))
				<div class="md-layout-item">
					<p class="mdl-typography--text-left mdl-typography--font-bold mdl-color-text--red-500">{{Session::get('errors')}}</p>
        </div>
				@endif
				@if (session('message'))
				<div class="md-layout-item">
					<p class="mdl-typography--text-center">{{session('message')}}</p>
        </div>
				@endif
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script async defer src="{{URL::to('js/log.js')}}"></script>
@endsection