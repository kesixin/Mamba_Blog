<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:37
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Page\CreateRequest;
use App\Http\Requests\Backend\Page\UpdateRequest;
use App\Repositories\PageRepositoryEloquent;

class PageController extends Controller
{

    protected $page;

    /**
     * PageController constructor.
     * @param PageRepositoryEloquent $page
     */
    public function __construct(PageRepositoryEloquent $page)
    {
        $this->page = $page;
    }

    /**
     * 列表页面
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pages = $this->page->all();
        return view('backend.page.index', compact('pages'));
    }

    /**
     * Show the form for creating
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.page.create');
    }

    /**
     * Store a newly created resource.
     * @param CreateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        if ($this->page->create($request->all())) {
            return redirect('backend/page')->with('success', '创建成功');
        }

        return redirect()->back()->withErrors('创建失败');

    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $page = $this->page->find($id);
        return view('backend.page.edit', compact('page'));
    }

    /**
     * Update the specified resource.
     * @param UpdateRequest $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        if ($this->page->update($request->all(), $id)) {
            return redirect('backend/page')->with('success', '修改成功');
        }

        return redirect()->back()->withErrors('修改失败');
    }

    /**
     * Delete the specified resource.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->page->delete($id)) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }

}