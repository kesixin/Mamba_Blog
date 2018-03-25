@extends('layouts.backend')

@section('title', '评论管理')

@section('header')
    <h1>
        评论管理
    </h1>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            @include('backend.alert.success')
            <div class="box box-solid">
                {{--<div class="box-header">--}}
                    {{--<form class="form-inline" action="" method="get">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="title">文章</label>&nbsp;--}}
                            {{--<input name='title' type="text" class="form-control" id="title" placeholder="请输入文章标题">&nbsp;--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="cate_id">分类</label>&nbsp;--}}
                            {{--@inject('categoryPresenter', 'App\Presenters\CategoryPresenter')--}}
                            {{--{!! $categoryPresenter->getSelect(0, '请选择', '') !!}--}}
                        {{--</div>--}}
                        {{--<button type="submit" class="btn btn-info">搜索</button>--}}
                        {{--<div class="pull-right">--}}
                            {{--<a href='{{ route("backend.article.create") }}' class='btn btn-success btn-xs'>--}}
                                {{--<i class="fa fa-plus"></i>发布文章</a>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding ">
                    <table class="table table-hover">
                        <tr>
                            <th>标题</th>
                            <th>内容</th>
                            <th>用户</th>
                            <th>邮箱</th>
                            <th>网站</th>
                            <th>ip</th>
                            <th>城市</th>
                            <th>操作</th>
                        </tr>
                        @if ($comments)
                            @inject('articlePresenter', 'App\Presenters\ArticlePresenter')
                            @foreach($comments as $comment)
                                <tr>
                                    <td><a href="/article/{{$comment->article_id}}" target="_blank">{{ $articlePresenter->formatTitle($comment->article->title) }}</a></td>
                                    <td>
                                        {{$comment->content}}
                                    </td>
                                    <td>{{ $comment->name }}</td>
                                    <td>{{ $comment->email }}</td>
                                    <td>{{ $comment->website }}</td>
                                    <td>
                                        {{$comment->ip}}
                                    </td>
                                    <td>{{ $comment->city }}</td>
                                    <td>
                                        <a data-href='{{ route("backend.comment.destroy", ["id" => $comment->id]) }}'
                                           class='btn btn-danger btn-xs article-delete'><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                <!-- /.box-body -->

                <div class="box-footer clearfix">
                    {!! $comments->links() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(function() {
            $(".article-delete").click(function(){
                var url = $(this).attr('data-href');
                Moell.ajax.delete(url);
            });
        });
    </script>
@endsection