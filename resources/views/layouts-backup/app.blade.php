<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{ asset('default/css/bootstrap.min.css') }}">

    <!-- Animate.css -->
    <link rel="stylesheet" href="{{ asset('default/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('default/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('default/css/people.css') }}" type="text/css" media="all">
    @yield('style')

</head>
<body>
@inject('systemPresenter', 'App\Presenters\SystemPresenter')
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url("/") }}" >{{ $systemPresenter->getKeyValue('blog_name') }}</a>
    </div>
        @include('default.navigation')
    </div>
</nav>
<!-- Main jumbotron for a primary marketing message or call to action -->
<!--people-->
<div id="app"></div>
<script type="text/javascript">
    var isindex=true;var title="";var visitor="游客";
</script>
<!--end people-->
<div class="jumbotron">
    <div class="container">
        <p>
            @yield('header-text')
        </p>
    </div>
</div>

<div class="container">
    <div class='row'>
        <div class='col-md-8' >
            @yield('content')
        </div>
        <div class='col-md-4'>
            @include('default.author')

            @include('default.tag')

            @include('default.hot')

            @include('default.link')
        </div>
    </div>
</div> <!-- /container -->

@include('default.footer')

<!-- jQuery -->
<script src="{{ asset('default/js/jQuery-2.2.0.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('default/js/bootstrap.min.js') }}"></script>
<!-- Waypoints -->
<script src="{{ asset('default/js/people.js') }}"></script>
<script src="{{ asset('default/js/index.js') }}"></script>


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

