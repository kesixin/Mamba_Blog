<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\Article\CreateRequest;
use App\Http\Requests\Backend\Article\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use BmobObject;
use Auth;

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
        if ($show) {
            $this->BmobObj = new BmobObject("articles");
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniIndex()
    {
        $result = $this->BmobObj->get("", array('keys=author,title,read_counts,createdAt,objectId', 'order=-createdAt'));
        $articles = $result->results;
        return view('backend.article.mini_index', compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniArticleCreate()
    {
        $BmobObj = new BmobObject("categories");
        $result = $BmobObj->get();
        $select = "<select id='category' name='category' class='form-control'>";
        $select .= "<option value='0'>--请选择--</option>";
        foreach ($result->results as $key => $value) {
            $selected = $value->objectId == 1 ? "selected" : "";
            $select .= "<option value='" . $value->objectId . "' " . $selected . ">" . $value->name . "</option>";
        }
        $select .= "</select>";
        return view('backend.article.mini_create',compact('select'));
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function miniArticleStore(Request $request)
    {
        $res=$this->BmobObj->addRelPointer(array(array("category","categories",$request->get('category'))));
        $res=$this->BmobObj->update($res->objectId,array(
            "title"=>$request->get('title'),
            "read_counts"=>(int)$request->get('read_counts'),
            "excerpt"=>$request->get('excerpt'),
            "author"=>$request->get('author'),
            "content"=>$request->get('html-content'),
            "mdcontent"=>$request->get('markdown-content')
        ));
        if (!$res) {
            return redirect()->back()->withErrors('系统异常，文章发布失败');
        }
        return redirect('backend/mini-index')->with('success', '文章添加成功');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniArticleEdit($id)
    {
        $article = $this->BmobObj->get($id, array('include=category.name'));

        $BmobObj = new BmobObject("categories");
        $result = $BmobObj->get();
        $select = "<select id='category' name='category' class='form-control'>";
        $select .= "<option value='0'>--请选择--</option>";
        foreach ($result->results as $key => $value) {
            $selected = $value->objectId == $article->category->objectId ? "selected" : "";
            $select .= "<option value='" . $value->objectId . "' " . $selected . ">" . $value->name . "</option>";
        }
        $select .= "</select>";

        return view('backend.article.mini_edit',compact('article','select'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function miniArticleUpdate(Request $request,$id)
    {
        $res = $this->BmobObj->updateRelPointer($id,"category","categories",$request->category);
        $res = $this->BmobObj->update($id,array(
            "title"=>$request->get('title'),
            "read_counts"=>(int)$request->get('read_counts'),
            "excerpt"=>$request->get('excerpt'),
            "author"=>$request->get('author'),
            "content"=>$request->get('html-content'),
            "mdcontent"=>$request->get('markdown-content')
        ));
        if (!$res) {
            return redirect()->back()->withErrors('系统异常，文章修改失败');
        }
        return redirect('backend/mini-index')->with('success', '文章修改成功');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function miniArticleDestroy($id)
    {
        $res = $this->BmobObj->delete($id);
        if(!$res){
            return response()->json([
                'status' => 1
            ]);
        }
        return response()->json(['status' => 0]);

    }


}