<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Category\CreateRequest;
use App\Http\Requests\Backend\Category\UpdateRequest;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\NavigationRepositoryEloquent;
use BmobObject;
use Symfony\Component\CssSelector\Parser\Reader;

class CategoryController extends Controller
{

    protected $category;
    protected $BmobObj;

    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
        $show = config('mini.show');
        if($show){
            $this->BmobObj = new BmobObject("categories");
        }
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

    /**
     * Update a category by id
     * @param UpdateRequest $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $result = $this->category->update($request->all(), $id);

        if ($result) {
            return redirect('backend/category')->with('success', '修改成功');
        }

        return redirect()->back()->withErrors('分类修改失败');
    }

    /**
     * Destroy a category by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->category->delete($id)) {
            return response()->json(['status' => 0]);
        }
        return response()->json(['status' => 1]);
    }

    /**
     * @param NavigationRepositoryEloquent $nav
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function setNavigation(NavigationRepositoryEloquent $nav, $id)
    {
        $category = $this->category->find($id);

        if($nav->setCategoryNav($category->id,$category->name)){
            return redirect()->back()->with('success','设置成功');
        }
        return redirect()->back()->withErrors('设置失败');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniCategoryIndex()
    {
        $result = $this->BmobObj->get("",array('order=createdAt'));
        $categories = $result->results;
        return view("backend.category.mini-index",compact("categories"));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniCategoryCreate()
    {
        return view("backend.category.mini-create");
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function miniCategoryStore(Request $request)
    {
        $res = $this->BmobObj->create(array('name'=>$request->get('name')));
        if (!$res) {
            return redirect()->back()->withErrors('系统异常，文章分类失败');
        }
        return redirect('backend/category-index')->with('success', '文章分类添加成功');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniCategoryEdit($id)
    {
        $category = $this->BmobObj->get($id);
        return view('backend.category.mini-edit',compact("category"));
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function miniCategoryUpdate(Request $request,$id)
    {
        $res = $this->BmobObj->update($id,array("name"=>$request->get('name')));
        if (!$res) {
            return redirect()->back()->withErrors('系统异常，分类修改失败');
        }
        return redirect('backend/category-index')->with('success', '分类修改成功');
    }

    public function miniCategoryDestroy($id)
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