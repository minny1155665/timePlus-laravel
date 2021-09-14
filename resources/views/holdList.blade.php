<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ config('APPNAME', '我主辦的活動') }}</title>
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
				<h1>Holding</h1>
				@forelse($holdings as $holding)
					<div class="ticket">
						<div id="photo">
							<img src="{{ asset('') }}{{ $holding->image }}" onclick="location.href='{{ route('events.show', ['event' => $holding]) }}'">
						</div>	
						<div id="inform">
							<p id="time">{{ $holding->date }}   {{ $holding->time }}</p>
							<a id="location" href="https://www.google.com.tw/maps/search/{{ $holding->location}}">{{ $holding->location }}</a>
							<p id="name">{{ $holding->name }}</p>
							<div id="delete">
								<form action="{{ route('events.destroy', ['event' => $holding]) }}"       method="POST">
									@method('delete')
									@csrf
									<input type="submit" value="取消活動">
								</form>
							</div>
							<a href="{{ route('end', ['event' => $holding]) }}">結束活動</a>
						</div>
					</div>
				@empty
					</br>
					<h1>目前無主辦中活動</h1>
					</br>
				@endforelse
			</div>
			<div id="pasttickets">
				<h1>Holded</h1>
				@forelse ($holdeds as $holded)
					<div class="pastticket">
						<div id="photo">
							<img src="{{ asset('') }}{{ $holded->image }}" onclick="location.href='{{ route('events.show', ['event' => $holded]) }}'">
						</div>
						<div id="inform">
							<a id="time" href="">{{ $holded->date }}   {{ $holded->time }}</a>
							<a id="location" href="https://www.google.com.tw/maps/search/{{ $holded->location }}">{{ $holded->location }}</a>
							<p id="name">{{ $holded->name }}</p>
						</div>
					</div>
				@empty
					</br>
					<h1>尚未主辦過活動</h1>
					</br>
				@endforelse
			</div>
		</article>
		
	@include('layouts.footer')

	</div>
</body>
</html>