@extends('layouts.backend')

@section('title','发布文章')

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('editor.md/css/editormd.min.css') }}">
@endsection
@section('header')
    <h1>
        发布文章
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('backend.alert.warning')
            <div class="box box-solid">
                <form role="form" method="post" action="{{ url('backend/mini-update',['id'=>$article->objectId]) }}" id="article-form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title">标题</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <input type='text' value="{{ $article->title }}" class='form-control' name="title" id='title' placeholder='标题'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc">描述(Description)</label>
                            <div class="row">
                                <div class='col-md-10'>
                                    <input type='text' value="{{ $article->excerpt }}" class='form-control' name="excerpt" id='excerpt' placeholder='请输入文章描述'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc">作者(Author)</label>
                            <div class="row">
                                <div class='col-md-10'>
                                    <input type='text' value="{{ $article->author }}" class='form-control' name="author" id='author' placeholder='请输入文章作者'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc">阅读数(Read_counts)</label>
                            <div class="row">
                                <div class='col-md-10'>
                                    <input type='text' value="{{ $article->read_counts }}" class='form-control' name="read_counts" id='read_counts' onkeyup="value=value.replace(/[^\d]/g,'')" placeholder='请输入文章阅读数'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content">文章内容</label>
                            <div id="editormd">
                                <textarea class="editormd-markdown-textarea" style="display:none;" id="content"
                                          name="markdown-content">{{ $article->mdcontent }}</textarea>
                                <textarea style="display:none;" name="html-content"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cate_id">文章分类</label>
                            <div class="row">
                                <div class='col-md-6'>
                                    <?php echo  $select; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{ csrf_field() }}
                    <div class="box-footer">
                        <button type="submit" id="submit-article" class="btn btn-primary">发布</button>
                        <button type="button" id="reset-btn" class="btn btn-warning">重置</button>
                    </div>
                </form>

            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('editor.md/editormd.min.js') }}"></script>
    <script>
        /* 配置editormd */
        var editor = editormd("editormd", {
            path: "{{ asset('/editor.md/lib/') }}/",
            height: 700,
            syncScrolling: "single",
            toolbarAutoFixed: false,
            saveHTMLToTextarea: false,
            imageUpload: true,
            imageFormats : ["jpg","jpeg","gif","png","bmp","webp"],
            imageUploadURL:"{{url('backend/uploadimage')}}"
        });
        /* 文章验证操作 */
        $("#article-form").bootstrapValidator({
            live: 'disables',
            message: "This Values is not valid",
            feedbackIcons: {
                valid: 'glyphicon',
                invalid: 'glyphicon',
                validation: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: "文章标题不能为空"
                        }
                    }
                },
                category: {
                    validators: {
                        notEmpty: {
                            message: "请选择文章分类"
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            var html = editor.getPreviewedHTML();
            $("#article-form textarea[name='html-content']").val(html);
        });
    </script>
@endsection