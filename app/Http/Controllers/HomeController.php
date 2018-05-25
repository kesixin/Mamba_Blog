<?php

namespace App\Http\Controllers;


use App\Repositories\ArticleRepositoryEloquent;

class HomeController extends Controller
{
    protected $article;

    /**
     * HomeController constructor.
     * @param ArticleRepositoryEloquent $article
     */
    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
    }

    /**
     * Show the resource dashboard.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = $this->article
            ->with('category')
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->paginate(15,['id','title','desc','created_at','read_count','cate_id','comment_count','list_pic']);
        return view('default.home',compact('articles'));
    }

    public function player()
    {
        return view('default.player');
    }

}