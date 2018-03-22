<?php

namespace App\Http\Controllers;


use App\Common\MyFunction;
use Illuminate\Http\Request;
use App\Repositories\CommentRepositoryEloquent;
use App\Services\CommentService;
use Auth;

class CommentController extends Controller
{

    /**
     * @var ArticleService
     */
    protected $commentServer;
    protected $comment;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentServer = $commentService;
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $city = MyFunction::getCity($request->ip());
        $arrData=array(
            'user_id'=>Auth::id() ? Auth::id() : 0,
            'parent_id'=>$request->parent_id ? $request->parent_id : 0,
            'article_id'=>$request->article_id,
            'content'=>$request->contents,
            'name'=>$request->name,
            'email'=>$request->email,
            'website'=>$request->website,
            'ip'=>$request->ip(),
            'city'=>$city['region'].' '.$city['city'],
            'target_name'=>$request->target_name
        );
        $comment=$this->commentServer->store($arrData);
        if($comment){
            return redirect()->back()->with('success', '发表成功');
        }else{
            return redirect()->back()->withErrors('发表失败');
        }
    }

}