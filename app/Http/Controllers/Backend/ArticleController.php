<?php

namespace App\Http\Controllers\Backend;
use App\Http\Requests\Backend\Article\CreateRequest;
use App\Http\Requests\Backend\Article\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use BmobObject;

class ArticleController extends Controller
{

    /**
     * @var ArticleService
     */
    protected $articleServer;
    protected $BmobObj;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleServer = $articleService;
        $show = config('mini.show');
        if($show){
            $this->BmobObj = new BmobObject("article");
        }
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
        return view('backend.article.index', compact('articles'));
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

    /**
     * Store a new article
     * @param CreateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        return $this->articleServer->store($request);
    }

    /**
     * Show the form for updating the article
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        return view('backend.article.edit')->with($this->articleServer->edit($id));
    }

    /**
     * Update the article by id
     * @param UpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->articleServer->update($request, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->articleServer->destroy($id);
    }

    public function miniArticle()
    {

    }


}