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
	<title>{{ config('APPNAME', '新增活動') }}</title>
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
	
	<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="newaparty">
	    	<div class="return"><h2>新增活動</h2></div>
	    	<div id="part1">
	    		活動照片
	        	<div class="uploadpic">
					<label for="image-upload"  id="cover">
						<img src="{{ asset('image/plus.png') }}" id="uploaded">
						<input type="file" name="image" id="image-upload">
					</label>					
	    		</div>
				</br>
	    		活動名稱
				<input type="text" placeholder="Name" name="name">
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
	   			<input type="date" name="date"><br>
	      		活動時間:<br>
	      		<input type="time" name="time"><br>
	        	活動地點:<br>
	        	<input type="text" placeholder="Location" name="location"><br>
	        	活動詳情
	        	<textarea name="content"></textarea>
			</div>
		
	    	<div id="part3">
				協辦名額
	    		<input type="number" placeholder="max" name="help">
	    		參加名額
	    		<input type="number" placeholder="max" name="attend">
	        	活動消耗點數
	        	<input type="number" placeholder="points" name="point">
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