<div class="menu">
    <nav class="nav" id="topnav">
        <h1 class="logo"><a href="{{ url("/") }}">{{ $systemPresenter->getKeyValue('blog_name') }}</a></h1>
        @inject('navPresenter', 'App\Presenters\NavigationPresenter')
        <?php $navigations = $navPresenter->getNavList(); ?>
        @if ($navigations)
            @foreach ($navigations as $navigation)
                <li><a href="{{ $navigation->url }}">{{ $navigation->name }}</a> </li>
            @endforeach
        @endif
        <!--search begin-->
        <div id="search_bar" class="search_bar">
            <form  id="searchform" action="{{ route('search') }}" method="get" name="searchform">
                <input class="input" placeholder="想搜点什么呢..." type="text" name="keyword" id="keyboard">
                <input type="hidden" name="Submit" value="搜索" />
                <span class="search_ico"></span>
            </form>
        </div>
        <!--search end-->
    </nav>
</div>
<!--mnav begin-->
<div id="mnav">
    <h2><a href="{{ url("/") }}" class="mlogo">{{ $systemPresenter->getKeyValue('blog_name') }}</a><span class="navicon"></span></h2>
    <dl class="list_dl">
        @inject('navPresenter', 'App\Presenters\NavigationPresenter')
        <?php $navigations = $navPresenter->getNavList(); ?>
        @if ($navigations)
            @foreach ($navigations as $navigation)
                <dt class="list_dt"> <a href="{{ $navigation->url }}">{{ $navigation->name }}</a> </dt>
            @endforeach
        @endif
    </dl>
</div>
<!--mnav end-->