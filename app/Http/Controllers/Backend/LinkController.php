<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 11:08
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Link\CreateRequest;
use App\Http\Requests\Backend\Link\UpdateRequest;
use App\Repositories\LinkRepositoryEloquent;

class LinkController extends Controller
{

    protected $link;

    /**
     * LinkController constructor.
     * @param LinkRepositoryEloquent $link
     */
    public function __construct(LinkRepositoryEloquent $link)
    {
        $this->link = $link;
    }

    /**
     * 链接列表页
     * Display a listing of the links.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $links = $this->link->all();
        return view('backend.link.index', compact('links'));
    }

    /**
     * 新建链接表单页
     * Show a form for creating a new resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.link.create');
    }

    /**
     * Store a newly created resource.
     * @param CreateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        if ($this->link->create($request->all())) {
            return redirect('backend/link')->with('success', '友情链接添加成功');
        }

        return redirect()->back()->withErrors('系统异常，友情链接添加失败');
    }

    /**
     * Show the form for updating the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $link = $this->link->find($id);
        return view('backend.link.edit', compact('link'));
    }

    /**
     * Update the specified resource.
     * @param UpdateRequest $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        if ($this->link->update($request->all(), $id)) {
            return redirect('backend/link')->with('success', '友情链接修改成功');
        }

        return redirect()->back()->withErrors('友情链接修改失败');
    }

    /**
     * Delete the specified resource.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->link->delete($id)) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }
}