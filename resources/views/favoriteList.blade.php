<?php
    use App\Http\Controllers\EventController;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ config('APPNAME', '收藏活動列表') }}</title>
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
            <h1>Favorite</h1>
            @forelse ($favorites as $fav):
                <div id="tickets">
                    <div class="ticket">
                        <div id="photo">
                            <img src="{{ asset('') }}{{ $fav->image }}" onclick="location.href='{{ route('events.show', ['event' => $fav]) }}'">
                        </div>
                        <div id="inform">
                            <a id="time" href="">{{ $fav->date }}   {{ $fav->time }}</a>
                            <a id="location" href="https://www.google.com.tw/maps/search/{{$fav->location}}">
                            {{$fav->location }}</a>
                            <p id="name">{{ $fav->name }}</p>
                            <a href="{{ route('cancelFav', ['event' => $fav]) }}">取消收藏</a>
                        </div>
                    </div>
                </div>  
            @empty
                </br>
                <h1>尚未收藏活動</h1>
            @endforelse
        </article>
        @include('layouts.footer')
	</div>
</body>
</html>