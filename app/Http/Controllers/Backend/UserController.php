<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Repositories\UserRepositoryEloquent;
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
        $users =$this->user->all(['id', 'name', 'email', 'user_pic'])->toArray();
        return view('backend.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request)
    {

        return view('backend.user.create');
    }
}