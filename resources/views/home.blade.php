@extends('layouts.app')

@section('content')

@push('header-scripts')
    <style>
		.category-box {
			display: flex;
			border-radius: 3px;
			align-items: center;
			justify-content: center;
			height: 150px;
			color: white;
		}
	</style>
@endpush

<carousel></carousel>

<!-- <div class="ui hidden divider"></div>

<div class="ui container mt-20">
	<div class="ui equal width center aligned divided grid">
		<div class="column">
			<div class="ui purple inverted segment">
				<h2>Публикувайте обучение</h2>
				<p>Добавете Вашите актуални обучение в Семинари 365</p>
				@if(auth()->check())
					@if(auth()->user()->role_id == 2)
					<a class="ui large basic inverted button" href="/dashboard#/events">Календар</a>
					@else
					<a class="ui large basic inverted button" href="/users/settings#/settings">Бизнес акаунт</a>
					@endif
				@else
				<a class="ui large basic inverted button" href="/register">Регистрация</a>
				@endif
			</div>
		</div>
		<div class="column">
			<div class="ui orange inverted segment">
				<h2>Зали и конферентни центрове</h2>
				<p>Открийте подходящата зала за Вашето събитие</p>
				<a class="ui large basic inverted button" href="/v">Зали</a>
			</div>
		</div>
	</div>
</div> -->

<!-- <div class="ui hidden divider"></div> -->
<!-- <event-feed></event-feed> -->
<section class="category-segment">
	<div class="ui container">
		@foreach($categories as $category)
			<div class="ui relaxed horizontal list">
				<div class="item">
					<a class="ui large basic inverted button" href="/browse/{{ $category->slug }}">{{ $category->name }}</a>
				</div>
			</div>
		@endforeach
	</div>
</section>

<div class="ui container mt-20">
	<div class="ui placeholder segment">
		<div class="ui icon header">
			<i class="question icon"></i>
			Желаете да публикувате в Семинари365?
		</div>
		<a href="/page/publish" class="ui primary button">Вижте как</a>
	</div>
</div>

<div class="ui container mt-20">
	@include('layouts.includes.event-feed')
</div>

<!-- <div class="ui container mt-20">
	
</div> -->
@endsection