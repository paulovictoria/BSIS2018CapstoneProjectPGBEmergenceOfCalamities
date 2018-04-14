@extends('layouts.app')
  @section('title', 'Login - PDRRMO Bulacan')
  @section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  @endsection
	@section('content')
  <div class="md-container">
			<div class="md-layout md-gutter md-alignment-center-space-around md-margin">
				<div class="md-layout-item md-gutter md-large-size-40 md-small-size-50 md-xsmall-size-70 md-elevation-1 md-form--padding animated fadeInUp mdl-color--white">
						<form action="{{route('login')}}" method="post">
					<p class="md-display-1 mdl-typography--text-center">
						PDRRMO Bulacan 
					</p>
					<md-field>
						<label>Email Address (Required)</label>
						<md-input name="email"
											type="email"
											required></md-input>
					</md-field>
					<md-field>
						<label>Password (Required)</label>
						<md-input name="password"
											type="password"
											required></md-input>
					</md-field>
		
					<div class="md-layout-item">
						<a href="{{route('register')}}" class="mdl-typography--text-left mdl-typography--body">Register!</a>
					</div>
					<div class="md-layout-item">
						<a href="{{route('forgot')}}" class="mdl-typography--text-left mdl-typography--body">Forgot Password?</a>
					</div>
					<div class="md-layout md-float__right">
						 <md-button  class="md-dense md-raised md-primary" type="submit">Login</md-button>
					</div>
					<input type="hidden" value="{{Session::token()}}" name="_token">
        </form>
        @if (Session::has('errors'))
				<div class="md-layout-item">
					<p class="mdl-typography--text-left mdl-color-text--red-500 mdl-typography--font-bold">{{Session::get('errors')}}</p>
        </div>
				@endif
				@if (session('message'))
				<div class="md-layout-item">
					<p class="mdl-typography--text-left mdl-typography--font-bold">{{session('message')}}</p>
        </div>
				@endif
				</div>
			</div>
		</div>
	@endsection
  @section('scripts')
    <script async defer src="{{URL::to('js/log.js')}}"></script>
  @endsection