<?php 
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/more.css') }}">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('scripts/eventmore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('scripts/returntop.js') }}"></script>
	<title></title>
</head>
<body>
	<div id="hidebg">
	    <div id="eventcontent">
	        <div class="return"><a  href="javascript:history.back()"><img src="{{ asset('image/close.png') }}"></a></div>
	        <div class="returntop"></div>
	        <img src="{{ asset('') }}{{ $event->image }}">

	        <article>
	            <p id="name">{{ $event->name }}</p>
				<p>發起人: <a id="holder" href="">{{ EventController::getHolderName($event->id); }}</a></p>
	            <p>時間: <a id="time">{{ $event->date }} {{ $event->time }}</a></p>
				<p>地點: <a id="location" href="https://www.google.com.tw/maps/search/{{ $event->location }}">
                {{ $event->location }}</a></p>
				<p>協辦名額: <a id="help">{{ $event->help_num }}</a></p>
				<p>參與名額: <a id="attend">{{ $event->attend_num }}</a></p>
				<p>消耗點數: <a id="point">{{ $event->attend_points }}pt</a></p>				
	            <!-- <p>協辦點數發放規則:</p>
	            <p id="rule">一人500點。限10人。</p> -->
	            <p>詳情:</p>
				<p id="more">{{ $event->content }}</p>
				</br>
	            <!-- <div id="numbers">目前參與人數: 6人</div> -->
	        </article>

			@if ($event->holder != Auth::id())
				<div class="buttons">
					<div id="contact">聯絡</div>   
					<div id="attend">參加</div>
					<div id="fun"></div>
				</div>
			@endif
	    </div>
	</div>
</body>
</html>