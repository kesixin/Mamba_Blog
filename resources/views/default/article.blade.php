@inject('userPresenter','App\Presenters\UserPresenter')
<?php
$author = isset($user->id) ? $user : $userPresenter->getUserInfo();
?>
@if($articles[0]!="")
    @foreach($articles as $article)
        <div class="blogs" data-scroll-reveal="enter bottom over 1s" >
            <h3 class="blogtitle"><a href="{{ route('article',['id'=>$article->id]) }}" target="_blank">{{ $article->title }}</a></h3>
            <span class="blogpic"><a href="{{ route('article',['id'=>$article->id]) }}" title="" target="_blank"><img src="{{ $article->list_pic }}" style="height: 120px;" alt=""></a></span>
            <p class="blogtext">{{ $article->desc }} </p>
            <div class="bloginfo">
                <ul>
                    <li class="author"><a>{{ $author->name }}</a></li>
                    @if($article->category)
                    <li class="lmname"><a href="{{ route('category', ['id' => $article->cate_id]) }}">{{ $article->category->name }}</a></li>
                    @endif
                    <li class="timer">{{ date('Y-m-d',strtotime($article->created_at)) }}</li>
                    <li class="view"><span>{{ $article->read_count }}</span> </li>
                    <li class="comment">{{ $article->comment_count }}</li>
                </ul>
            </div>
        </div>
    @endforeach
    {!! $articles->links() !!}
@else
    <br/><br/><br/>
    <h2 style="color: #666;">Ooops...没找到你想要的 ：(</h2>
    <span>您可以尝试搜点别的 或 <a href="{{ url("/") }}" >返回首页</a></span>
    <br><br><br>
@endif