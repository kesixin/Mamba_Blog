<div class="links">
    <h2 class="hometitle">友情链接</h2>
    @inject('linkPresenter', 'App\Presenters\LinkPresenter')
    <ul>
        <?php $links = $linkPresenter->linkList() ?>

        @if ($links)
            @foreach ($links as $link)
                <li><a href="{{ $link->url }}" target="_blank">{{ $link->name }}</a></li>
            @endforeach
        @endif
    </ul>
</div>