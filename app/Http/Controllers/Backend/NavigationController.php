<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/5
 * Time: 15:31
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Navigation\CreateRequest;
use App\Http\Requests\Backend\Navigation\UpdateRequest;
use App\Repositories\NavigationRepositoryEloquent;

class NavigationController extends Controller
{

    protected $navigation;

    /**
     * NavigationController constructor.
     * @param NavigationRepositoryEloquent $navigation
     */
    public function __construct(NavigationRepositoryEloquent $navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $navigations = $this->navigation
            ->with(['category'])
            ->orderBy('sequence', 'desc')
            ->all();

        return view('backend.navigation.index', compact('navigations'));
    }

    /**
     * Show the form for creating a new navigation.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.navigation.create');
    }

    /**
     * @param CreateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        if ($this->navigation->create($request->all())) {
            return redirect('backend/navigation')->with('success', '导航添加成功');
        }

        return redirect()->back()->withErrors('导航添加失败');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $navigation = $this->navigation->find($id);

        return view('backend.navigation.edit', compact('navigation'));
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        if ($this->navigation->update($request->all(), $id)) {
            return redirect('backend/navigation')->with('success', '修改成功');
        }

        return redirect()->back()->withErrors('修改失败');

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->navigation->delete($id)) {
            return response()->json(['status' => 0]);
        }

        return response()->json(['status' => 1]);
    }


}