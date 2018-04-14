@extends('layouts.app')
	@section('title', 'Register - PDRRMO Bulacan')
	@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  @endsection
	@section('content')
  <div class="md-container">
			<div class="md-layout md-gutter md-alignment-center-space-around md-margin">
				<div class="md-layout-item md-gutter md-large-size-40 md-small-size-50 md-xsmall-size-70 md-elevation-1 md-form--padding animated fadeInUp mdl-color--white">
						<form action="{{route('register')}}" method="post">
					<p class="md-display-1 mdl-typography--text-center">
						Register
					</p>
						<md-field>
							<label>Email Address..</label>
							<md-input name="email"
												type="email"
												required></md-input>
						</md-field>
						@if ($errors->has('email'))
							<span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('email') }}</span>	
						@endif
						{{--    --}}
					<md-field>
						<label>Password..</label>
						<md-input name="password"
											type="password"></md-input>
					</md-field>
						@if ($errors->has('password'))
							<span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('password') }}</span>	
						@endif
						{{--    --}}
					<md-field>
						<label>Full Name..</label>
						<md-input type="text" 
											name="name"></md-input>
					</md-field>
						@if ($errors->has('name'))
							<span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('name') }}</span>	
						@endif
						{{--    --}}
					<div class="mdlext-selectfield mdlext-js-selectfield mdlext-selectfield--floating-label">
						<select class="mdlext-selectfield__select" id="municipality" name="municipality">
							<option value=""></option>
							<option :value="municipality.name" v-for="municipality in municipalities">@{{municipality.name}}</option>
						</select>
						<label class="mdlext-selectfield__label" for="municipality">Municipality</label>
					</div>
					@if ($errors->has('municipality'))
							<span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('municipality') }}</span>	
					@endif
					{{--    --}}
					<md-field>
						<label>Municipal Address..</label>
						<md-input type="text" name="municipalAddress"></md-input>
					</md-field>
					@if ($errors->has('municipalAddress'))
							<span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('municipalAddress') }}</span>	
					@endif
					{{--    --}}
					<md-field>
						<label>Contact Number..</label>
						<md-input type="text" name="usercontact"></md-input>
					</md-field>
					@if ($errors->has('usercontact'))
							<span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('usercontact') }}</span>	
					@endif
				{{--    --}}
					<div class="md-layout-item">
						<a href="/login" class="mdl-typography--text-left mdl-typography--body">Login</a>
					</div>
					<div class="md-layout-item">
						<a href="/forgot" class="mdl-typography--text-left mdl-typography--body">Forgot Password?</a>
					</div>
					<div class="md-layout md-float__right">
						 <md-button  class="md-dense md-raised md-primary" type="submit">Register</md-button>
					</div>
					<input type="hidden" value="{{Session::token()}}" name="_token">
				</form>
				</div>
			</div>
		</div>
	@endsection
	@section('scripts')
		<script async defer src="{{URL::to('js/log.js')}}"></script>
	@endsection