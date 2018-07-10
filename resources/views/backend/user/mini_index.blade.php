@extends('layouts.backend')

@section('title', '用户列表')

@section('header')
    <h1>
        用户列表（总计：{{ $count }}）
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @include('backend.alert.success')
            <div class="box box-solid">
                <!-- /.box-header -->
                <div class="box-header">
                    <div class="pull-right">
                        <div class="btn-group">
                        </div>
                    </div><!-- pull-right -->
                </div>
                <div class="box-body table-responsive no-padding ">
                    <table class="table table-hover">
                        <tr>
                            <th>序号</th>
                            <th>头像</th>
                            <th>名字</th>
                            <th>username</th>
                            <th>openid</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        @if ($users)
                            <?php $line = 1  ?>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $line }}</td>
                                    <td>
                                        <img src="{{ isset($user->userPic)?$user->userPic:"" }}" class="img-circle" style="width:30px;height:auto;">
                                    </td>
                                    <td>{{ isset($user->nickName)?$user->nickName:"" }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->authData->weapp->openid }}</td>
                                    <td>{{ $user->createdAt }}</td>
                                    <td>
                                        <a data-href='{{ route("backend.user.user-destroy", ["id" => $user->objectId]) }}'
                                           class='btn btn-danger btn-xs user-delete'><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>

                                </tr>
                                <?php $line++ ?>
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
            $(".user-delete").click(function(){
                var url = $(this).attr('data-href');
                Moell.ajax.delete(url);
            });
        });
    </script>
@endsection