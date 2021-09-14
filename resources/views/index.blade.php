<?php
    use App\Http\Controllers\EventController;

    $url = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimePlus</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/basic.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/hmbanner.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/nav.css') }}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Comfortaa" />
    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/banner.js') }}"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>  
	<div id='app'>
		<header class="toplogo">    	
			<h1 class="logo">
                <img src="{{ asset('image/logo1.png') }}">
            </h1>
        </header>
        <!-- <div class="searchbar">
            <img src="image/search.png" alt="">
            <input type="text" id="txtSearch" onChange="txtSearch()" placeholder="搜尋">
        </div> -->
    	<div id="all">
            <div class="nav">
                <ul>
                    <li class="active">政大<br>藝術季</li>
                    <li>政大<br>包種茶</li>
                    <li>台北<br>蚤之市</li>
                    <li>貴人<br>散步</li>
                    <li>2020<br>ttf</li>
                </ul>
            </div>
            <div class="banner">
                <img src="{{ asset('image/party1.jpg') }}" alt="" />
                <img src="{{ asset('image/party2.jpg') }}" alt="" />
                <img src="{{ asset('image/party3.jpg') }}" alt="" />
                <img src="{{ asset('image/party4.jpg') }}" alt="" />
                <img src="{{ asset('image/party5.jpg') }}" alt="" />
            </div>
        </div>
        <div id="cattitle">分類：</div>
        <div class="selectcat">

            <a>
                <img src="{{ asset('image/cat1.png') }}">
                愛心公益
            </a>
            <a>
                <img src="{{ asset('image/cat2.png') }}">
                技能交換
            </a>
            <a>
                <img src="{{ asset('image/cat3.png') }}">
                揪團
            </a>
            <a>
                <img src="{{ asset('image/cat4.png') }}">
                其他
            </a>
        </div>
    	<article>
    		<header>
    			<h2>🔥活動列表</h2>

    			<div class="order">
                    {{ Form::select('size', [
                        'new'=>'新->舊',
                        'old'=>'舊->新',
                        'close'=>'舉辦時間近->遠',
                        'far'=>'舉辦時間遠->近',
                        'many'=>'消耗點數多->少',
                        'few'=>'消耗點數少->多'], 
                        'new') 
                    }}
    			</div>
    		</header>
            <div class="helporattend">
                <div><button onclick="location.href='{{ route('help.show') }}'">協辦</button></div>
                <div><button onclick="location.href='{{ route('attend.show') }}'">參加</button></div>
            </div>
            <div id="eventlist">  
                <!-- 顯示所有活動，分為參加與協辦 -->
                @foreach($events as $event)
                    <!-- 選出狀態是not_yet的活動 -->
                    <div class="events">
                        <a id='imga'href="{{ route('events.show', ['event' => $event]) }}">
                            <div class="eventimg" id="coverpic"
                                style="background-image: url('{{ asset('') }}{{ $event->image }}')" >
                            </div>
                        </a>
                        <div>
                            <h3 id="name">{{ $event->name }}</h3>
                            <p id="time" href="">{{ $event->date }}   {{ $event->time }}</p>
                            <a id="location" href="https://www.google.com.tw/maps/search/{{$event->location}}">
                                {{ $event->location }}
                            </a>
                            <br>    
                        </div>
                        <!-- 登入後才能執行的動作 -->
                            <!-- 是舉辦活動者 -->
                                <!-- 編輯活動 -->
                                <!-- 刪除活動 -->
                            <!-- 不是舉辦活動者 -->
                                <!-- 收藏活動 -->
                                <!-- 參加活動 -->                           
                        <div id="btnarea">
                            @if (!is_null(Auth::user()))
                                @if (Auth::id() == $event->holder)
                                    <div id="edit" onclick="location.href='{{ route('events.edit', 
                                    ['event' => $event]) }}'">編輯</div>
                                    <div id="delete">
                                        <form action="{{ route('events.destroy', ['event' => $event]) }}"       method="POST">
                                            @method('delete')
                                            @csrf
                                            <input type="submit" value="取消活動">
                                        </form>
                                    </div>
                                @else
                                    @if (EventController::isFavorite($event))
                                        <div id="have_interested" onclick="location.href='{{ route('cancelFav', 
                                        ['event' => $event]) }}'"></div>
                                    @else
                                        <div id="interested" onclick="location.href='{{ route('favorite', 
                                        ['event' => $event]) }}'"></div>
                                    @endif

                                    @if (EventController::isAttended($event))
                                        <div id="attended">已報名</div>
                                    @else
                                        @if (str_contains($url, 'attend'))
                                            <div id="attendyet" onclick="location.href='{{ route('attend', 
                                            ['event' => $event]) }}'">報名</div>
                                        @elseif (str_contains($url, 'help'))
                                            <div id="attendyet" onclick="location.href='{{ route('help', 
                                            ['event' => $event]) }}'">報名</div>
                                        @else
                                            <div id="attendyet" onclick="alert('請先選擇協辦或參加')">報名</div>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach

                <div id="page">
                    {!! $events->links() !!}
                </div>  
            </div>
        </article>

		<footer>
            <div>
            </div>
		</footer>
        @include('layouts.footer')
	</div>   
</body>
</html>