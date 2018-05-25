<?php

namespace App\Http\Controllers;


use App\Repositories\CategoryRepositoryEloquent;

class CategoryController extends Controller
{
    protected $category;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryEloquent $category
     */
    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
    }

    /**
     * 通过分类查询文章
     * Get the category and select the specified articles.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $category = $this->category->find($id);
        $articles = $category->article()
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15,['id','title','desc','created_at','read_count','cate_id','comment_count','list_pic']);
        return view('default.category_article', compact('category', 'articles'));
    }
}