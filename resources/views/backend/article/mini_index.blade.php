@extends('layouts.backend')

@section('title', '文章管理')

@section('header')
    <h1>
        文章管理
    </h1>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            @include('backend.alert.success')
            <div class="box box-solid">
                <div class="box-header">
                    <form class="form-inline" action="" method="get">
                        <div class="pull-right">
                            <a href='{{ route("backend.article.mini-create") }}' class='btn btn-success btn-xs'>
                                <i class="fa fa-plus"></i>发布文章</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding ">
                    <table class="table table-hover">
                        <tr>
                            <th>序号</th>
                            <th>作者</th>
                            <th>标题</th>
                            <th>阅读数</th>
                            <th>分类</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                        @if ($articles)
                            @inject('articlePresenter', 'App\Presenters\ArticlePresenter')

                            <?php $line = 1 ?>
                            @foreach($articles as $article=>$value)
                                <tr>
                                    <td>{{ $line }}</td>
                                    <td>
                                        @if($value->author)
                                            {{ $value->author }}
                                        @endif
                                    </td>
                                    <td>{{ $articlePresenter->formatTitle($value->title) }}</td>
                                    <td>{{ $value->read_counts }}</td>
                                    <td>
                                        <?php
                                            if(!empty($articles[$article]->category->name)){
                                                echo $articles[$article]->category->name;
                                            }

                                        ?>
                                    </td>
                                    <td>{{ $value->createdAt }}</td>
                                    <td>
                                        <a href='{{ route("backend.article.mini-edit", ["id" => $value->objectId]) }}' class='btn btn-info btn-xs'>
                                            <i class="fa fa-pencil"></i> 修改</a>
                                        <a data-href='{{ route("backend.article.mini-destroy", ["id" => $value->objectId]) }}'
                                           class='btn btn-danger btn-xs article-delete'><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>
                                </tr>
                                        <?php $line++ ?>
                            @endforeach
                        @endif
                    </table>
                </div>
                <!-- /.box-body -->
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