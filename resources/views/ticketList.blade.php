<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ config('APPNAME', '票券') }}</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/eventlist.css') }}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" />
</head>
<body>
	<header class="toplogo">    	
		<h1 class="logo">
			<img src="{{ asset('image/logo1.png') }}">
		</h1>
	</header>
	<div id="app">
    <article>
			<div id="tickets">
				<h1>協辦</h1>
				@forelse ($helps as $help)
					<div class="ticket">
						<div id="photo">
							<img src="{{ asset('') }}{{ $help->image }}"  onclick="location.href='{{ route('events.show', ['event' => $help]) }}'">
						</div>
						<div id="inform">
							<a id="time" href="">{{ $help->date }}   {{ $help->time }}</a>
							<a id="location" href="https://www.google.com.tw/maps/search/{{$help->location }}">{{ $help->location }}</a>
							<p id="name">{{ $help->name }}</p>
							<a href="{{ route('cancelAttend', ['event' => $help]) }}">取消報名</a>
						</div>
					</div>
				@empty
					</br>
					<h1>尚未報名協辦活動</h1>
					</br>
				@endforelse
			</div>
			<div id="tickets">
				<h1>參與</h1>
				@forelse ($attends as $attend)
					<div class="ticket">
						<div id="photo">
							<img src="{{ asset('') }}{{ $attend->image }}"  onclick="location.href='{{ route('events.show', ['event' => $attend]) }}'">
						</div>
						<div id="inform">
							<a id="time" href="">{{ $attend->date }}   {{ $attend->time }}</a>
							<a id="location" href="https://www.google.com.tw/maps/search/{{$attend->location }}">{{ $attend->location }}</a>
							<p id="name">{{ $attend->name }}</p>
							<a href="{{ route('cancelAttend', ['event' => $attend]) }}">取消報名</a>
						</div>
					</div>
				@empty
					</br>
					<h1>尚未報名參與活動</h1>
					</br>
				@endforelse
			</div>
		</article>
		
		@include('layouts.footer')

	</div>
</body>
</html>