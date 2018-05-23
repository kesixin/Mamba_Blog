<div class="panel panel-default">
    <div class="panel-heading">热门文章</div>

    @inject('articlePresenter','App\Presenters\ArticlePresenter')

    <?php  $hotArticleList = $articlePresenter->hotArticleList(); ?>

    <ul class="list-group">
        @if($hotArticleList)
            @foreach($hotArticleList as $item)
                <li class="list-group-item">
                    <span class="badge">{{ $item->read_count }}</span>
                    <a href="{{ route('article', ['id' => $item->id]) }}" target="_blank">
                        {{ $articlePresenter->formatTitle($item->title) }}
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</div>

<div class="tuijian">
    <h2 class="hometitle">点击排行</h2>
    <ul class="tjpic">
        <i><img src="images/toppic01.jpg"></i>
        <p><a href="/">别让这些闹心的套路，毁了你的网页设计</a></p>
    </ul>
    <ul class="sidenews">
        <li> <i><img src="images/toppic01.jpg"></i>
            <p><a href="/">别让这些闹心的套路</a></p>
            <span>2018-05-13</span> </li>
        <li> <i><img src="images/toppic02.jpg"></i>
            <p><a href="/">给我模板PSD源文件，我给你设计HTML！</a></p>
            <span>2018-05-13</span> </li>
        <li> <i><img src="images/v1.jpg"></i>
            <p><a href="/">别让这些闹心的套路，毁了你的网页设计</a></p>
            <span>2018-05-13</span> </li>
        <li> <i><img src="images/v2.jpg"></i>
            <p><a href="/">给我模板PSD源文件，我给你设计HTML！</a></p>
            <span>2018-05-13</span> </li>
    </ul>
</div>