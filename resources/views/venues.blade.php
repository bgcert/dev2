@extends('layouts.app')

@section('content')
<div class="ui container">
    <h2>venues</h2>
    <venue-feed
		auth="{{ auth()->check() }}"
		>
	</venue-feed>
</div>
@endsection