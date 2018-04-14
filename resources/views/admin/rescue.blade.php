@extends('layouts.app')
	@section('title', 'Rescue Map - PDRRMO Bulacan')
	@section('content')
		<rescue></rescue>
	@endsection
@section('scripts')
<script async defer src="{{URL::to('js/rescue.js')}}"></script>
@endsection
