<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Repositories\CommentRepositoryEloquent;

class CommentController extends Controller
{

    /**
     * CommentController constructor.
     * @param CommentRepositoryEloquent $comment
     */
    public function __construct(CommentRepositoryEloquent $comment)
    {
        $this->comment=$comment;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $comments=$this->comment->paginate('15');
        return view('backend.comment.index',compact('comments'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if($this->comment->delete($id)) {
            return response()->json(['status' => 0]);
        }
        return response()->json(['status' => 1]);
    }

}