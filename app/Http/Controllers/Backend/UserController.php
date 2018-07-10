<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\CreateRequest;
use App\Http\Requests\Backend\User\UpdateRequest;
use App\Repositories\UserRepositoryEloquent;
use App\Services\ImageUploads;
use Beta\B;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use BmobObject;
use App\Common\CustomPage;

class UserController extends Controller
{

    protected $user;

    /**
     * UserController constructor.
     * @param UserRepositoryEloquent $user
     */
    public function __construct(UserRepositoryEloquent $user)
    {
        $this->user = $user;
        $show = config('mini.show');
        if ($show) {
            $this->BmobObj = new BmobObject("_User");
        }
    }

    /**
     * Display a listing of the resource
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->all(['id', 'name', 'email', 'user_pic'])->toArray();
        return view('backend.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.create');
    }


    /**
     * Store a newly created resource in storage.
     * @param CreateRequest $request
     * @param ImageUploads $imageUploads
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request, ImageUploads $imageUploads)
    {
        if ($request->hasFile('user_pic')) {
            $file = $request->file('user_pic');

            $upload = $imageUploads->uploadAvatar($file);
            if (!$upload['status']) {
                return redirect()->back()->withErrors($upload['msg']);
            }
        }

        $avatarFileName = isset($upload['fileName']) ? $upload['fileName'] : '';

        if ($this->user->store($request->all(), $avatarFileName)) {
            return redirect('backend/user')->with('success', '用户添加成功');
        }

        return redirect()->back()->withErrors('系统异常，用户添加失败');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        return view('backend.user.edit', compact('user'));
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @param ImageUploads $imageUploads
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id, ImageUploads $imageUploads)
    {
        $user = $this->user->find($id);

        if ($request->hasFile('user_pic')) {
            $file = $request->file('user_pic');

            $upload = $imageUploads->uploadAvatar($file);

            if (!$upload['status']) {
                return redirect()->back()->withErrors($upload['msg']);
            }
        }

        $avatarFileName = isset($upload['fileName']) ? $upload['fileName'] : '';

        if ($this->user->update($request->all(), $id, $avatarFileName)) {
            if ($avatarFileName != "" && $user['user_pic'] != "") {
                Storage::disk('upload')->delete('avatar/' . $user['user_pic']);
            }

            return redirect('backend/user')->with('success', ' 用户修改成功');
        }

        return redirect()->back()->withErrors('用户修改失败');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->user->delete($id)) {
            return response()->json([
                'status' => 0
            ]);
        }

        return response()->json([
            'status' => 1
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniUserIndex(Request $request)
    {
        $pageSize = 40;//每页条数
        if ($request->get('nowPage')) {
            $nowPage = $request->get('nowPage');//当前页码
        } else {
            $nowPage = 1;
        }
        $res = $this->BmobObj->get("", array('groupcount=true', 'groupby=createdAt' . 'order=-createdAt'));
        $count = $res->results[0]->_count;//总条数
        $countPage = ceil($count / $pageSize);//总页数
        $pages = CustomPage::getSelfPageView($nowPage, $countPage, '/backend/user-index', '');
        $skip = ($nowPage-1)*$pageSize;
        $res = $this->BmobObj->get("",array("limit=$pageSize","skip=$skip",'order=-createdAt'));
        $users = $res->results;

        return view('backend.user.mini_index',compact("pages","users","count"));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function miniUserDestroy($id)
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