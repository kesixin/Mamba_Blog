<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Repositories\CommentRepositoryEloquent;
use Illuminate\Http\Request;
use BmobObject;
use App\Common\CustomPage;

class CommentController extends Controller
{

    /**
     * CommentController constructor.
     * @param CommentRepositoryEloquent $comment
     */
    public function __construct(CommentRepositoryEloquent $comment)
    {
        $this->comment=$comment;
        $show = config('mini.show');
        if ($show) {
            $this->BmobObj = new BmobObject("comments");
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $comments=$this->comment->orderBy('id', 'desc')->paginate('15');
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function miniIndex(Request $request)
    {
        $pageSize = 20;//每页条数
        if ($request->get('nowPage')) {
            $nowPage = $request->get('nowPage');//当前页码
        } else {
            $nowPage = 1;
        }

        $res = $this->BmobObj->get("", array('groupcount=true', 'groupby=createdAt' . 'order=-createdAt'));
        $count = $res->results[0]->_count;//总条数
        $countPage = ceil($count / $pageSize);//总页数
        $pages = CustomPage::getSelfPageView($nowPage, $countPage, '/backend/comment-index', '');
        $skip = ($nowPage-1)*$pageSize;
        $res = $this->BmobObj->get("",array("limit=$pageSize","skip=$skip",'order=-createdAt','include=replyer,user'));

        $comments = $res->results;

        return view('backend.comment.mini_index',compact("pages","comments","count"));
    }

    public function miniDestroy($id)
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