<div class="cloud">
    <h2 class="hometitle">标签云</h2>
    <ul>
        @inject('tagPresenter', 'App\Presenters\TagPresenter')
        <?php
        $tagList = $tagPresenter->tagList();
        ?>
        @if($tagList)
            @foreach($tagList as $item)
                <a href="{{ route('tag', ['id' => $item->id]) }}" target="_blank">{{ $item->tag_name }}</a>
            @endforeach
        @endif
    </ul>
</div>