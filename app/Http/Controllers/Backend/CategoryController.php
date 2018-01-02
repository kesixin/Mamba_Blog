<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Category\CreateRequest;
use App\Http\Requests\Backend\Category\UpdateRequest;
use App\Repositories\CategoryRepositoryEloquent;

class CategoryController extends Controller
{

    protected $category;

    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $category = $this->category->getNestedList();
        return view('backend.category.index', compact('category'));
    }

    /**
     * Show a form for creating a new category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resoure in storage.
     * @param CreateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $result = $this->category->store($request->all());

        if ($result) {
            return redirect('backend/category')->with('success', '分类添加成功');
        }

        return redirect(route('backend/category/create'))->withErrors('分类添加失败');
    }

    /**
     * Show the form for editing the category
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        return view('backend.category.edit', compact('category'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result=$this->category->update($request->all(),$id);

        if($result){
            return redirect('backend/category')->with('success','修改成功');
        }

        return redirect()->back()->withErrors('分类修改失败');
    }
}