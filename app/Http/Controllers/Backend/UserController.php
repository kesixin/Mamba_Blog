<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\CreateRequest;
use App\Http\Requests\Backend\User\UpdateRequest;
use App\Repositories\UserRepositoryEloquent;
use App\Services\ImageUploads;
use Illuminate\Support\Facades\Storage;

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

            return redirect('backend/user')->with('success',' 用户修改成功');
        }

        return redirect()->back()->withErrors('用户修改失败');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if($this->user->delete($id)){
            return response()->json([
                'status'=>0
            ]);
        }

        return response()->json([
            'status'=>1
        ]);
    }
}