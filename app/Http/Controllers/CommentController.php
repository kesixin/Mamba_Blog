<?php

namespace App\Http\Controllers;


use App\Common\MyFunction;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Repositories\CommentRepositoryEloquent;
use App\Repositories\ArticleRepositoryEloquent;
use App\Services\CommentService;
use Auth;
use Mail;

class CommentController extends Controller
{

    /**
     * @var ArticleService
     */
    protected $commentServer;
    protected $article;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(CommentService $commentService,ArticleRepositoryEloquent $article)
    {
        $this->commentServer = $commentService;
        $this->article = $article;
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
            $article = $this->article->find($request->article_id);
            $article->comment_count = $article->comment_count + 1;
            $article->save();
//            if($request->comment_id){
//                $commentData=$this->commentServer->selectByParentId($request->comment_id);
//                if($commentData->email){
//                    $url=url('/article/'.$request->article_id);
//                    $this->mail($commentData->email,$url);
//                }
//            }
            return json_encode(['resultCode'=>'200']);
        }else{
            return json_encode(['resultCode'=>'400']);
        }
    }

    public function mail($Mail,$url){
        $flag = Mail::send('default/mail',['url'=>$url],function($message) use ($Mail){
            $to=$Mail;
            $message ->to($to)->subject('评论回复');
        });
        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }
    }

}