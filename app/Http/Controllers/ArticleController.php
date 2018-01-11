<?php

namespace App\Http\Controllers;


use App\Repositories\ArticleRepositoryEloquent;

class ArticleController extends Controller
{

    protected $article;

    /**
     * ArticleController constructor.
     * @param ArticleTagRepositoryEloquent $article
     */
    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
    }

    /**
     * 显示文章详情
     * Display article.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $article = $this->article->find($id);
        $article->read_count = $article->read_count + 1;
        $article->save();
        return view('default.show_article', compact('article'));
    }

}