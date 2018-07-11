@inject('systemPresenter','App\Presenters\SystemPresenter')

@extends('layouts.app')

@section('title',$systemPresenter->checkReturnValue('title',$article->title))

@section('description',$systemPresenter->checkReturnValue('seo_desc',$article->desc))

@section('keywords',$systemPresenter->checkReturnValue('seo_keyword',$article->keyword))

@inject('userPresenter','App\Presenters\UserPresenter')
<?php
$author = isset($user->id) ? $user : $userPresenter->getUserInfo();
?>
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
    @include('backend.alert.success')
    <input type="hidden" id="action">
    <input type="hidden" id="replyid">
    <div class="infosbox" style="width: 100%;">
        <div class="newsview">
            <h3 class="news_title">{{ $article->title }}</h3>
            <div class="bloginfo">
                <ul>
                    <li class="author"><a>{{$author->name}}</a></li>
                    <li class="lmname"><a href="{{ route('category',['id'=>$article->cate_id]) }}">{{ $article->category->name }}</a></li>
                    <li class="timer">{{ date("Y-m-d" ,strtotime($article->created_at)) }}</li>
                    <li class="view">{{ $article->read_count }}</li>
                    <li class="comment">{{ $article->comment_count }}</li>
                </ul>
            </div>
            <div class="tags">
                @foreach( $article->tag as $tag )
                    <a href="{{ route('tag',['id'=>$tag->id]) }}">{{ $tag->tag_name }}</a> &nbsp;
                @endforeach

            </div>

            <div class="news_con">
                <div class="markdown-body editormd-html-preview" style="padding:0;">
                    {!! $article->html_content !!}
                </div>
                <div style="margin-top:20px;">
                    <div id="share" class="social-share" data-disabled="google,twitter,facebook,diandian"></div>
                </div>
                <br><br>
                <p class="z-counter">
                <h4 style="display: inline-block;">评论 {{ $article->comment_count }}</h4>
                <a href="" onclick="return false" style="float:right" data-toggle="modal" data-target="#commentModal"><h4><span class="glyphicon glyphicon-pencil" ></span>发表评论</h4></a>
                </p>
                <div class="z-comments" id="commentdiv">
                    @foreach ($comments as $comment)
                        <hr id="comment{{ $comment->id }}">
                        @if( $comment->user_id == 1 )
                            <img src="{{ asset('uploads/avatar')."/".$author->user_pic }}" class="img-circle z-avatar">
                            <p class="z-name z-center-vertical">{{ $author->name }} <span class="label label-info z-label">博主</span></p>
                        @elseif( $comment->website )
                            <p class="z-avatar-text"><?php echo $comment['avatar_text'] ? $comment['avatar_text'] : '匿' ?></p>
                            <a href="{{ $comment->website }}" target="_blank">
                                <p class="z-name"><?php echo $comment['name'] ? $comment['name'] : '匿名' ?></p>
                            </a>
                        @else
                            <p class="z-avatar-text"><?php echo $comment['avatar_text'] ? $comment['avatar_text'] : '匿' ?></p>
                            <p class="z-name"><?php echo $comment['name'] ? $comment['name'] : '匿名' ?></p>
                        @endif
                        <p class="z-content">{{ $comment->content }}</p>
                        <p class="z-info">{{ $comment->created_at_diff }} · {{ $comment->city }} <span data-toggle="modal" data-target="#commentModal" data-replyid="{{ $comment->id }}" data-replyname="{{ $comment->name }}" data-commentid="{{ $comment->id }}" id="replyid{{ $comment->id }}" class="glyphicon glyphicon-share-alt z-reply-btn"></span></p>
                        <div class="z-reply" id="commentid{{ $comment->id }}">
                            @foreach( $comment->replys as $reply )
                                @if( $reply->user_id == 1 )
                                    <img src="{{ asset('uploads/avatar')."/".$author->user_pic }}" class="img-circle z-avatar">
                                    <p class="z-name z-center-vertical">{{ $author->name }} <span class="label label-info z-label">博主</span></p>
                                @elseif( $reply->website )
                                    <p class="z-avatar-text"><?php echo $reply['avatar_text'] ? $reply['avatar_text'] : '匿' ?></p>
                                    <a href="{{ $reply->website }}" target="_blank">
                                        <p class="z-name"><?php echo $reply['name'] ? $reply['name'] : '匿名' ?></p>
                                    </a>
                                @else
                                    <p class="z-avatar-text"><?php echo $reply['avatar_text'] ? $reply['avatar_text'] : '匿' ?></p>
                                    <p class="z-name"><?php echo $reply['name'] ? $reply['name'] : '匿名' ?></p>
                                @endif
                                <p class="z-content">回复 <b>{{ $reply->target_name }}</b>：{{ $reply->content }}</p>
                                <p class="z-info">{{ $reply->created_at_diff }} · {{ $reply->city }} <span data-toggle="modal" data-target="#commentModal" data-replyid="{{ $comment->id }}" data-replyname="{{ $reply->name }}" data-commentid="{{ $reply->id }}" id="replyid{{ $comment->id }}" class="glyphicon glyphicon-share-alt z-reply-btn"></span></p>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            {{--<strong>发表评论</strong>--}}
            {{--@if($systemPresenter->getKeyValue('comment_script') !="")--}}
            {{--<div id="SOHUCS" sid="{{ route('article', ['id' => $article->id]) }}" ></div>--}}
            {{--{!! $systemPresenter->getKeyValue('comment_script') !!}--}}
            {{--@endif--}}


            <!-- comment Modal -->
                <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">发表评论</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" id="form1">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputFile">留言</label>
                                        <textarea class="form-control" id="contents" name="contents" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">昵称</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="[选填] 怎么称呼？" value="{{ $inputs->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">邮箱</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="[选填] 如果有人回复，会收到邮件提醒" value="{{ $inputs->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">个人网站</label>
                                        <input type="text" class="form-control" id="website" name="website" placeholder="[选填] 包含 http:// 或 https:// 的完整域名" value="{{ $inputs->website }}">
                                    </div>
                                    <input type="text" id="parent_id" name="parent_id" style="display:none">
                                    <input type="text" id="target_name" name="target_name" style="display:none">
                                    <input type="text" id="comment_id" name="comment_id" style="display:none">
                                    <input type="text" name="article_id" value="{{ $article->id }}" style="display:none">
                                    <input type="submit" id="commentFormBtn"  style="display:none">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary" onclick="comment()">发表</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('share.js/js/jquery.share.min.js') }}"></script>

    <script>
        $('#commentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            if (button.data('replyid')) {
                var replyid = button.data('replyid')
                var replyname = button.data('replyname') ? button.data('replyname') : '匿名'
                var commentid = button.data('commentid')
                var modal = $(this)
                modal.find('#parent_id').val(replyid)
                modal.find('#target_name').val(replyname)
                modal.find('#content').attr("placeholder", "回复 @"+replyname)
                modal.find('#comment_id').val(commentid)
                $('#action').val('reply');
                $('#replyid').val('commentid'+replyid);
            }else {
                var modal = $(this)
                modal.find('#parent_id').val(0)
                modal.find('#target_name').val('')
                modal.find('#content').attr("placeholder", "")
                $('#action').val('comment');
            }
        })

        $(function(){
            $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
        });

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });

        function comment() {
            $content=$('#contents').val();
            if($content==null || $content==''){
                document.getElementById('commentFormBtn').click();
                return false;
            }else{
                if($('#email').val()!=''){
                    var reg1 = /[a-zA-Z0-9]{1,10}@[a-zA-Z0-9]{1,5}/;
                    if(!reg1.test($('#email').val())){
                        document.getElementById('commentFormBtn').click();
                        return false;
                    }
                }
                $.ajax({
                    type: "POST",//方法类型
                    dataType: "json",//预期服务器返回的数据类型
                    url: "/comment" ,//url
                    data: $('#form1').serialize(),
                    success: function (result) {
                        console.log(result);//打印服务端返回的数据(调试用)
                        if (result.resultCode == 200) {
                            $('contents').val('');
                            $('#commentModal').modal('hide');

                            var action=$('#action').val();
                            if(action=='comment'){
                                document.all.commentdiv.insertAdjacentHTML("afterBegin",result.html);
                            }else{
                                var replyid=$('#replyid').val();
                                $('#'+replyid).append(result.html);
                            }
                            $.ajax({
                                type:'GET',
                                dataType:'json',
                                url:'/send',
                                data:{'comment_id':result.comment_id,'article_id':result.article_id},
                                success:function (res) {

                                },
                                error:function () {

                                }
                            });
                        }else{

                        }
                    },
                    error : function() {
                        alert("服务器异常，请稍后评论！");
                    }
                });
            }
        }
        $(document).ready(function() { //为超链接加上target='_blank'属性
        $('.markdown-body a[href^="http"]').each(function() {
                $(this).attr('target', '_blank');
            });
        });
    </script>

@endsection