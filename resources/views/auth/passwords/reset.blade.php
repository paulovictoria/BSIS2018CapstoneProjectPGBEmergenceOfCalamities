@extends('layouts.app')
@section('title', 'Reset Password - PDRRMO Bulacan')
@section('content')
  <div class="md-container">
    <div class="md-layout md-gutter md-alignment-center-space-around md-margin">
      <div class="md-layout-item md-gutter md-large-size-40 md-small-size-50 md-xsmall-size-70 md-elevation-1 md-form--padding">
        <form action="{{route('reset')}}" method="post">
          <p class="md-display-1 mdl-typography--text-center">
            Reset Password
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
            <label>New Password..</label>
            <md-input name="password"
                      type="password"
                      required></md-input>
          </md-field>
          @if ($errors->has('password'))
          <span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('email') }}</span>	
          @endif 
          {{--    --}}
          <md-field>
            <label>Retype Password..</label>
            <md-input name="confirmPassword"
                      type="password"
                      required></md-input>
          </md-field>
          @if ($errors->has('confirmPassword'))
          <span class="md-error mdl-color-text--red-500 mdl-typography--font-bold">{{ $errors->first('email') }}</span>	
          @endif 
        {{--    --}}
          <div class="md-layout md-float__right">
            <md-button  class="md-dense md-raised md-primary" type="submit">Submit</md-button>
          </div>
          <input type="hidden" value="{{Session::token()}}" name="_token">
        </form>
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
