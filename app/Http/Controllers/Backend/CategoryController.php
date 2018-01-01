<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepositoryEloquent;

class CategoryController extends Controller
{

    protected $category;

    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category=$category;
    }

    /**
     * Display a listing of the category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $category=$this->category->getNestedList();
        return view('backend.category.index',compact('category'));
    }

    /**
     * Show a form for creating a new category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.category.create');
    }
}