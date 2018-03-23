@inject('systemPresenter', 'App\Presenters\SystemPresenter')

@extends('default.page')

@section('title', $systemPresenter->checkReturnValue('title', $page->title))

@section('description', $systemPresenter->checkReturnValue('seo_desc', $page->desc))

@section('keywords', $systemPresenter->checkReturnValue('seo_keyword', $page->keyword))

@section('style')
    <link rel="stylesheet" href="{{ asset('editor.md/css/editormd.preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('share.js/css/share.min.css') }}">
@endsection

@section('header-text')
    <div class="text-inner">
        <div class="row to-animate fadeInUp animated">
            <div class="col-md-12">
                <h3 class="color-white">
                    {{ $page->title }}
                </h3>

                <p class="color-white m-t-25">
                    {{ $page->desc }}
                </p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="markdown-body editormd-html-preview" style="padding:0;">
        {!! $page->html_content !!}
    </div>

    <div style="margin-top:20px;">
        <div id="share" class="social-share"></div>
    </div>

    {{--<br><br>--}}
    {{--<strong>发表评论</strong>--}}
    {{--@if($systemPresenter->getKeyValue('comment_script') !="")--}}
        {{--<div id="SOHUCS" sid="{{ route('page.show', ['alias' => $page->link_alias]) }}" ></div>--}}
        {{--{!! $systemPresenter->getKeyValue('comment_script') !!}--}}
    {{--@endif--}}
@endsection

@section('script')
    <script src="{{ asset('share.js/js/jquery.share.min.js') }}"></script>

    <script>
        $(function(){
            $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
        });
    </script>

@endsection
