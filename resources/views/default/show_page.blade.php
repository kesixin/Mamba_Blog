@inject('systemPresenter', 'App\Presenters\SystemPresenter')

@extends('layouts.app')

@section('title', $systemPresenter->checkReturnValue('title', $page->title))

@section('description', $systemPresenter->checkReturnValue('seo_desc', $page->desc))

@section('keywords', $systemPresenter->checkReturnValue('seo_keyword', $page->keyword))

@section('style')
    <link rel="stylesheet" href="{{ asset('default/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('editor.md/css/editormd.preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('share.js/css/share.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body{
            background: #f6f6f6;
        }
        header{
            background: none;
        }
        .nav li{
            list-style: none;
        }
        ul,li{
            list-style: disc;
        }
        .nav>li>a:focus, .nav>li>a:hover{
            background: none;
        }
        .nav>li>a{
            padding: 0 20px;
            font: 15px "Microsoft YaHei", Arial, Helvetica, sans-serif;
            line-height: 80px;
        }
        .logo>a{
            font: 26px "Microsoft YaHei", Arial, Helvetica, sans-serif;
            font-weight: bold;
        }
        .logo>a:hover{
            text-decoration:none ;
            color: #00A7EB;
        }

    </style>
@endsection


@section('content')
    <div class="infosbox" style="width: 100%;">
        <div class="newsview">
            <div class="news_con">
                <div class="markdown-body editormd-html-preview">
                    {!! $page->html_content !!}
                </div>
                <div style="margin-top:20px;">
                    <div id="share" class="social-share" data-disabled="google,twitter,facebook,diandian"></div>
                </div>
                <br><br>
            </div>
        </div>
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
        $('.markdown-body a[href^="http"]').each(function() {
            $(this).attr('target', '_blank');
        });
    </script>

@endsection
