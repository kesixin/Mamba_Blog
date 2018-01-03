<?php


namespace App\Services;


use Illuminate\Http\Request;
use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\TagRepositoryEloquent;
use Auth;

class ArticleService
{
    protected $article;

    protected $tag;

    public function __construct(ArticleRepositoryEloquent $article,TagRepositoryEloquent $tag)
    {
        $this->article=$article;
        $this->tag=$tag;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $where=[];
        if($request->has('title')){
            $where[]=['title','like',"%".$request->title."%"];
        }

        if($request->has('cate_id')){
            $where[]=['cate_id','=',$request->cate_id];
        }

        return $this->article->with([
            'user',
            'category'
        ])->search($where);
    }

    public function store(Request $request)
    {
        $article = $this->article->create(array_merge($this->basicFields($request),
            ['user_id'=>Auth::id()]
        ));

        if(!$article){
            return redirect()->back()->withErrors('系统异常，文章发布失败');
        }

        if($request->has('tags')){

        }

        return redirect('backend/article')->with('success','文章添加成功');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function basicFields(Request $request)
    {
        return array_merge($request->intersect([
            'title',
            'keyword',
            'desc',
            'cate_id',
            'user_id',
        ]),[
            'content' =>$request->get('markdown-content'),
            'html_content'=>$request->get('html-content')
        ]);
    }


}