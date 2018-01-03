<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\Article\CreateRequest;
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

    /**
     * 文章列表
     * Display a listing of the articles
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $articles = $this->articleServer->search($request);
        return view('backend.article.index',compact('articles'));
    }

    /**
     * 新建文章--表单
     * Show the form for creating a new article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.article.create');
    }

    public function store(CreateRequest $request)
    {
        return $this->articleServer->store($request);
    }





}