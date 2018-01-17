@extends('layouts.backend')

@section('title', '博客设置')

@section('header')
    <h1>
        博客设置
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @include('backend.alert.warning')
            @include('backend.alert.success')
            <div class="box box-solid">
                <form role="form" method="post" enctype="multipart/form-data" action="{{ url('backend/system') }}" id="system-form" >
                    <div class="box-body">
                        <div class="form-group">
                            <label for="blog_name">博客名字</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type='text' value="{{ $system['blog_name'] }}" class='form-control' name="blog_name" id='blog_name' placeholder='请输入博客名字'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="motto">博客格言</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type='text' value="{{ $system['motto'] }}" class='form-control' name="motto" id='motto' placeholder='请输入博客格言'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">标题</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type="text"  value="{{ $system['title'] }}" class='form-control' name="title" id="title" placeholder="请输入标题">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seo_keyword">SEO 关键字</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type="text"  value="{{ $system['seo_keyword'] }}" class='form-control' name="seo_keyword" id="seo_keyword" placeholder="请输入SEO关键字">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seo_desc">SEO 描述</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type="text"  value="{{ $system['seo_desc'] }}" class='form-control' name="seo_desc" id="seo_desc" placeholder="请输入SEO 描述">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seo_desc">Github 地址</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type="text"  value="{{ $system['github_url'] }}" class='form-control' name="github_url" id="github_url" placeholder="请输入Github 地址">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="seo_desc">QQ</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type="text"  value="{{ $system['qq'] }}" class='form-control' name="qq" id="qq" placeholder="请输入qq">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment_plugin">评论插件</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <select class='form-control' name="comment_plugin" id="comment_plugin" >
                                        <option value="">请选择</option>
                                        <option value="LiveRe" {{ $system['comment_plugin'] == 'LiveRe' ? " selected " : "" }}>来必力</option>
                                        <option value="changyan" {{ $system['comment_plugin'] == 'changyan' ? " selected " : "" }}>畅言</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="icp">ICP 备案号</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type="text"  value="{{ $system['icp'] }}" class='form-control' name="icp" id="icp" placeholder="请输入ICP 备案号">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="statistics_script">统计脚本</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <textarea class="form-control" name="statistics_script" rows="5" placeholder="请输入合法的javascript统计脚本">{{ $system['statistics_script'] }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment_script">评论脚本</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <textarea class="form-control" name="comment_script" rows="5" placeholder="请输入合法的javascript统计脚本">{{ $system['comment_script'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ csrf_field() }}


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-warning" id="reset-btn">重置</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection