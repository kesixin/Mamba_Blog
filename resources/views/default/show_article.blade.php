@inject('systemPresenter','App\Presenters\SystemPresenter')

@extends('layouts.app')

@section('title',$systemPresenter->checkReturnValue('title',$article->title))

@section('description',$systemPresenter->checkReturnValue('seo_desc',$article->desc))

@section('keywords',$systemPresenter->checkReturnValue('seo_keyword',$article->keyword))

@section('style')
    <link rel="stylesheet" href="{{ asset('editor.md/css/editormd.preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('share.js/css/share.min.css') }}">
@endsection

@section('header-text')
    <div class="text-inner">
        <div class="row">
            <div class="col-md-12 to-animate fadeInUp animated">
                <h3 class="color-white">
                    {{ $article->title }}
                </h3>

                <p class=" m-t-25 color-white">
                    <i class="glyphicon glyphicon-calendar"></i>{{ date("Y-m-d" ,strtotime($article->created_at)) }}
                    @if($article->category)
                        <i class="glyphicon glyphicon-th-list"></i>
                        <a href="{{ route('category',['id'=>$article->cate_id]) }}" target="_blank">
                            {{ $article->category->name }}
                        </a>
                    @endif
                </p>
                @if($article->tag)
                    <p class="color-white">
                        <i class="glyphicon glyphicon-tags"></i>&nbsp;
                        @foreach( $article->tag as $tag )
                            <a href="{{ route('tag',['id'=>$tag->id]) }}" target="_blank">
                                {{ $tag->tag_name }}
                            </a>&nbsp;
                        @endforeach
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="markdown-body editormd-html-preview" style="padding:0;">
        {!! $article->html_content !!}
    </div>
    <div style="margin-top:20px;">
        <div id="share" class="social-share"></div>
    </div>
    <br><br>
    <strong>发表评论</strong>
    @if($systemPresenter->getKeyValue('comment_script') !="")
        <div id="SOHUCS" sid="{{ route('article', ['id' => $article->id]) }}" ></div>
        {!! $systemPresenter->getKeyValue('comment_script') !!}
    @endif
@endsection

@section('script')
    <script src="{{ asset('share.js/js/jquery.share.min.js') }}"></script>

    <script>
        $(function(){
            $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
        });
    </script>

@endsection