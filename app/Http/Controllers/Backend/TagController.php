<?php


namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Tag\CreateRequest;
use App\Http\Requests\Backend\Tag\UpdateRequest;
use App\Repositories\TagRepositoryEloquent;

class TagController extends Controller
{

    protected $tag;

    /**
     * TagController constructor.
     * @param TagRepositoryEloquent $tag
     */
    public function __construct(TagRepositoryEloquent $tag)
    {
        $this->tag=$tag;
    }

    /**
     * Display a listing of the tags.
     * 显示标签列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $tags=$this->tag->paginate('15');
        return view('backend.tag.index',compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     * 显示创建新标签的表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     * 将新建的标签保存
     * @param CreateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $data=[];
        $data['tag_name']=$request->name;
        if($this->tag->create($data)){
            return redirect('/backend/tag')->with('success','添加标签成功');
        }

        return redirect(route('backend.tag.create'))->withErrors('标签添加失败');
    }

    /**
     * Show the form for editing the specified resource.
     * 显示编辑指定资源的表单。
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tag=$this->tag->find($id);
        return view('backend.tag.edit',compact('tag'));
    }

    /**
     *
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request,$id)
    {
        $data=[];
        $data['tag_name']=$request->name;
        if($this->tag->update($data,$id)){
            return redirect('/backend/tag')->with('success','标签修改成功');
        }

        return redirect()->back()->withErrors('标签修改失败');
    }

    public function destroy($id)
    {
        if($this->tag->delete($id)){
            return response()->json(['status'=>0]);
        }

        return response()->json(['status'=>1]);
    }
}