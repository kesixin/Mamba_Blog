<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link href="{{ asset('default/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('default/css/index_new.css') }}" rel="stylesheet">
    <link href="{{ asset('default/css/m-new.css') }}" rel="stylesheet">
    <link href="{{ asset('default/css/people.css') }}" rel="stylesheet">
    @yield('style')
    <style>
        #cnzz_stat_icon_1264398044{
            display: inline-block;
        }
        h2{
            margin-top: 0;
        }
    </style>
</head>
<body>
@inject('systemPresenter', 'App\Presenters\SystemPresenter')

<header>
    <!--menu begin-->
    @include('default.navigation')
    <!--menu end-->
</header>
<!-- Main jumbotron for a primary marketing message or call to action -->
<!--people-->
<div id="app"></div>
<script type="text/javascript">
    var isindex=true;var title="";var visitor="游客";
</script>
<!--end people-->
<article>
    <div class="blogsbox">
        @yield('content')
    </div>
    <div class="sidebar">
        @include('default.hot')

        @include('default.tag')

        @include('default.link')

        @include('default.author')
    </div>
</article>
@include('default.footer')
<script src="{{ asset('default/js/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset('default/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('default/js/jquery.easyfader.min.js') }}"></script>
<script src="{{ asset('default/js/people.js') }}"></script>
<script src="{{ asset('default/js/conn.js') }}"></script>
<script src="{{ asset('default/js/nav.js') }}"></script>
<script src="{{ asset('default/js/scrollReveal.js') }}"></script>
<!--[if lt IE 9]>
<script src="{{ asset('default/js/modernizr.js') }}"></script>
<![endif]-->


<script>
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>


@yield('script')
</body>
</html>

