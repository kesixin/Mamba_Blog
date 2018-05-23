<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">标签</h3>
    </div>
    <div class="panel-body">
    @inject('tagPresenter', 'App\Presenters\TagPresenter')
    <?php
        $tagList = $tagPresenter->tagList();
    ?>
    @if($tagList)
        @foreach($tagList as $item)
            <span style="padding: 5px;">
                <a href="{{ route('tag', ['id' => $item->id]) }}" target="_blank">{{ $item->tag_name }}</a>
            </span>
        @endforeach
    @endif
    </div>
</div>