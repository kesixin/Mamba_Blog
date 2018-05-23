@if($articles[0]!="")
    <ol class="article-list">
        @foreach($articles as $article)
            <li>
                <h4 class="title">
                    <a href="{{ route('article',['id'=>$article->id]) }}" target="_blank">
                        {{ $article->title }}
                    </a>
                </h4>
                <p class="desc">
                    {{ $article->desc }}
                </p>
                <p class="info">
                    <span>
                        <i class="glyphicon glyphicon-calendar"></i>{{ date('Y-m-d',strtotime($article->created_at)) }}
                    </span>
                    <span>&nbsp;</span>

                    @if($article->category)
                        <span>
                            <i class="glyphicon glyphicon-th-list"></i>
                            <a href="{{ route('category', ['id' => $article->cate_id]) }}" target="_blank">
                                {{ $article->category->name }}
                            </a>
                        </span>
                        <span>&nbsp;</span>
                    @endif

                    <span>
                        <i class="glyphicon glyphicon-eye-open"></i> {{ $article->read_count }}
                    </span>
                    <span>&nbsp;</span>

                </p>
            </li>
            <hr/>
        @endforeach
    </ol>
    {!! $articles->links() !!}
@else
    <br/><br/><br/>
    <h2 style="color: #666;">Ooops...没找到你想要的 ：(</h2>
    <span>您可以尝试搜点别的 或 <a href="{{ url("/") }}" >返回首页</a></span>
    <br><br><br>
@endif