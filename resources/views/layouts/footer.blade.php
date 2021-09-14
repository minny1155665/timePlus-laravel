<div class="navigation">
    <div id="main">
        <div onclick="location.href=' {{ route('events.index') }} '">首頁</div>
            <!-- 新增活動、票券、個人要登入才能看到 -->
            <div onclick="location.href=
                @if (is_null(Auth::user()))
                    '{{ url('/register') }}'
                @else
                    '{{ route('events.create') }}'
                @endif
            "><img src="{{ asset('image/logo/add.svg') }}"></div>
            <div onclick="location.href=
                @if (is_null(Auth::user()))
                    '{{ url('/register') }}'
                @else
                    '{{ url('/ticket_list') }}'
                @endif
            ">票券</div>
            <div onclick="location.href=
                @if (is_null(Auth::user()))
                    '{{ url('/register') }}'
                @else
                    '{{ url('/personal_page/'.Auth::id()) }}'
                @endif
            ">個人</div>  
        </div> 
</div>