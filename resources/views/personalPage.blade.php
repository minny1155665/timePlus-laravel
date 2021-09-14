<?php
use App\Http\Controllers\UserController;
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href=" {{asset('css/personal.css')}} ">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" />
	<title>{{ config('APP NAME', 'TimePlus') }}</title>
</head>
<body>
	<div id="app">
		<div id="personalpc"></div>
		<h2>{{ $user->name }}</h2>
		<div id="pointsarea">
			<div>
				點數:<br>
				<h2>{{ $user->total_points }} pts</h2>
			</div>
			<div>
				參加活動數:<br>
				<h2>{{ UserController::getAttendedEventNum() }} 場</h2>
			</div>
		</div>
		<ul>
            <!-- <li>編輯個人檔案</li> -->
            <li onclick="location.href=' {{ url('/hold_list') }} '">我主辦的活動</li>
			<li onclick="location.href=' {{ url('/favorite_list') }} '">收藏活動</li>
			<li onclick="location.href=' {{ url('/auth/logout') }} ';">登出</li>
			<!-- <li>設定</li> -->
		</ul>
	</div>

	@include('layouts.footer')

</body>
</html>