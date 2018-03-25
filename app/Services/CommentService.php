<?php

namespace App\Services;


use Illuminate\Http\Request;
use App\Repositories\CommentRepositoryEloquent;
use App\Models\Comment;

class CommentService
{

    protected $comment;

    /**
     * CommentService constructor.
     * @param CommentRepositoryEloquent $comment
     */
    public function __construct(CommentRepositoryEloquent $comment)
    {
        $this->comment=$comment;
    }

    /**
     * @param Request $request
     * @param $user_id
     * @param $city
     * @return bool
     */
    public function store(array $arrData)
    {
        $comment=$this->comment->create($arrData);
        if($comment){
            return $comment;
        }else{
            return false;
        }
    }

    /**
     * @param $parent_id
     * @return mixed
     */
    public function selectByParentId($comment_id)
    {
        $comment=$comment = Comment::where('id',$comment_id)->orderBy('created_at', 'desc')->first();
        return $comment;
    }

    /**
     * 数组赋值
     * @param Request $request
     * @return array
     */
    public function basicFields(Request $request)
    {
        return array_merge($request->intersect([
            'user_id',
            'parent_id',
            'article_id',
            'content',
            'name',
            'email',
            'website',
            'ip',
            'city',
            'target_name',
        ]));
    }

}