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
                <div class="box-body table-responsive no-padding ">
                    <table class="table table-hover">
                        <tr>
                            <th>内容</th>
                            <th>评论者</th>
                            <th>被评论者</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                        @if ($comments)
                            @foreach($comments as $comment=>$value)
                                <tr>
                                    <td>
                                        {{$value->content}}
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($comments[$comment]->replyer->nickName)){
                                            echo $comments[$comment]->replyer->nickName;
                                        }

                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(!empty($comments[$comment]->user->nickName)){
                                            echo $comments[$comment]->user->nickName;
                                        }

                                        ?>
                                    </td>
                                    <td>{{ $value->createdAt }}</td>
                                    <td>
                                        <a data-href='{{ route("backend.comment.mini-destroy", ["id" => $value->objectId]) }}'
                                           class='btn btn-danger btn-xs article-delete'><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
                <!-- /.box-body -->

                <div class="box-footer clearfix">
                    {!! $pages !!}
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