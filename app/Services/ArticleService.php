<?php


namespace App\Services;


use Illuminate\Http\Request;
use App\Repositories\ArticleRepositoryEloquent;

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


}