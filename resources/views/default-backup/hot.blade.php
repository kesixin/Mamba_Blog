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