<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepositoryEloquent;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    protected $article;

    /**
     * SearchController constructor.
     * @param ArticleRepositoryEloquent $article
     */
    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $articles = $this->article->searchKeywordArticle($request->keyword);
        return view('default.search_article', compact('articles'));
    }
}
