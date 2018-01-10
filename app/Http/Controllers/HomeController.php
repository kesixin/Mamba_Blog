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
        return view('default.home');
    }

}