<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 22:44
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\SystemRepositoryEloquent;


class SystemController extends Controller
{

    protected $system;

    /**
     * SystemController constructor.
     * @param SystemRepositoryEloquent $system
     */
    public function __construct(SystemRepositoryEloquent $system)
    {
        $this->system = $system;
    }

    /**
     * 系统配置页面
     * Show the form for system setting
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $system = $this->system->optionList();
        return view('backend.system.index', compact('system'));
    }

    /**
     * 保存系统设置
     * Save system settings
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($this->system->store($request->all())) {
            return redirect()->back()->with('success', '操作成功');
        }
        return redirect()->back()->withErrors('操作失败');
    }
}