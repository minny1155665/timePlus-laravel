<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/basic.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/nav.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/newact.css') }}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" />
	<script type="text/javascript" src="scripts/returntop.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="scripts/jquery.js"></script>
	<title>{{ config('APPNAME', '編輯活動') }}</title>
</head>
<!-- <script>
	$(document).ready(function(){
		$("#cover").live('click',function(){
			$("#image-upload").click();
		});
	});
</script> -->
<body>
	<header class="toplogo">    	
		<h1 class="logo">
			<img src="{{ asset('image/logo1.png') }}">
		</h1>
	</header>
	
	<form action="{{ route('events.update', ['event' => $event]) }}" method="POST" enctype="multipart/form-data">
		@method('PUT')
		@csrf
		<div class="newaparty">
	    	<div class="return"><h2>編輯活動</h2></div>
	    	<div id="part1">
	    		活動照片
	        	<div class="uploadpic">
					<label for="image-upload"  id="cover">
						@if (!isset($event->image))
							<img src="{{ asset('image/plus.png') }}" id="uploaded">
						@else
							<img src="{{ asset('') }}{{ $event->image }}" id="uploaded">
						@endif	
						<input type="file" name="image" id="image-upload">
					</label>					
	    		</div>
				</br>
	    		活動名稱
				<input type="text" name="name" value="{{ $event->name }}">
				<!-- 活動類別
      			<select>
       				<option>愛心公益</option>
       				<option>技能交換</option>
       				<option>揪團</option>
       				<option>其他</option>
      			</select> -->
			</div>
		
	    	<div id="part2">
	   			活動日期:<br>
	   			<input type="date" name="date" value="{{ $event->date }}"><br>
	      		活動時間:<br>
	      		<input type="time" name="time" value="{{ $event->time }}"><br>
	        	活動地點:<br>
	        	<input type="text" name="location" value="{{ $event->location }}"><br>
	        	活動詳情
	        	<textarea name="content">{{ $event->content }}</textarea>
			</div>
		
	    	<div id="part3">
				協辦名額
	    		<input type="number" name="help" value="{{ $event->help_num }}">
	    		參加名額
	    		<input type="number" name="attend" value="{{ $event->attend_num }}">
	        	活動消耗點數
	        	<input type="number" name="point" value="{{ $event->attend_points }}">
	        	<!-- 點數發放方式
	    		<select>
	    			<option>每人均分</option>
	    			<option>前*位均分</option>
	    			<option>不發放</option>
	    		</select> -->
			</div>
		
	    	<div id="btn">
	    		<div class="laststep" onclick="location.href='{{ route('events.index') }}';">回首頁</div>
	    		<div class="nextstep"><input type="submit" name="submit" value="完成"></div>
			</div>
			<div id="space"></div>
		</div> 
	</form>

	@include('layouts.footer')	
</body>
</html>