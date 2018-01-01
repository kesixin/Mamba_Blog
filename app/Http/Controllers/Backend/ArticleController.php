<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ArticleService;

class ArticleController extends Controller
{

    /**
     * @var ArticleService
     */
    protected $articleServer;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleServer = $articleService;
    }

    public function index(Request $request)
    {
        $articles = $this->articleServer->search($request);
        return view('backend.article.index',compact('articles'));
    }



}