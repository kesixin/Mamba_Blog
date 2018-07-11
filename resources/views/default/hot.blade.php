<div class="tuijian">
    @inject('articlePresenter','App\Presenters\ArticlePresenter')

    <?php  $hotArticleList = $articlePresenter->hotArticleList(); ?>
    <h2 class="hometitle">点击排行</h2>
    <ul class="sidenews">
        @if($hotArticleList)
            @foreach($hotArticleList as $item)
            <li> <i><img src="{{$item->list_pic}}" style="width:100%;"></i>
            <p><a href="{{ route('article', ['id' => $item->id]) }}" target="_blank">{{ $articlePresenter->formatTitle($item->title) }}</a></p>
            <span>{{ date('Y-m-d',strtotime($item->created_at)) }}</span> </li>
            @endforeach
        @endif
    </ul>
</div>