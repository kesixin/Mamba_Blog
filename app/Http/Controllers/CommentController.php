<?php

namespace App\Http\Controllers;


use App\Common\MyFunction;
use App\Models\Article;
use App\Models\Comment;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\CommentRepositoryEloquent;
use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
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
    protected $user;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(CommentService $commentService,ArticleRepositoryEloquent $article,UserRepositoryEloquent $user)
    {
        $this->commentServer = $commentService;
        $this->article = $article;
        $this->user = $user;
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
            $html='';
            $head =$request->name? mb_substr($request->name,0,1,'utf-8'):'匿';
            $name=$request->name? $request->name:'匿名';
            if($request->parent_id==0){

                $html='<hr>'.'<p class="z-avatar-text">'.$head.'</p>'.
                    '<p class="z-name">'.$name.'</p>'.'<p class="z-content">'.$request->contents.'</p>'.
                '<p class="z-info">'.$arrData['city']. '<span data-toggle="modal" data-target="#commentModal" data-replyid="'.$comment->id.'" data-replyname="'.$arrData['name'].'" data-commentid="'.$comment->id.'" id="replyid'.$comment->id.'" class="glyphicon glyphicon-share-alt z-reply-btn"></span></p><div class="z-reply"></div>';
            }else{
                $html='<p class="z-avatar-text">'.$head.'</p>'.
                    '<p class="z-name">'.$name.'</p>'.'<p class="z-content">回复 <b>'.$request->target_name.'</b>：'. $request->contents .'</p>.'.
                    '<p class="z-info">'.$arrData['city']. '<span data-toggle="modal" data-target="#commentModal" data-replyid="'.$request->parent_id.'" data-replyname="'.$arrData['name'].'" data-commentid="'.$comment->id.'" id="replyid'.$request->parent_id.'" class="glyphicon glyphicon-share-alt z-reply-btn"></span></p>';
            }
            return json_encode(['resultCode'=>'200','comment_id'=>$request->comment_id,'article_id'=>$request->article_id,'data'=>$arrData,'html'=>$html]);
        }else{
            return json_encode(['resultCode'=>'400']);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function send(Request $request)
    {
        $userInfo = $this->user->getUserInfo();
        $url=url('/article/'.$request->article_id);
        $this->mail($userInfo->email,$url);
        if($request->comment_id){
            $commentData=$this->commentServer->selectByParentId($request->comment_id);
            if($commentData->email){
                $url=url('/article/'.$request->article_id);
                $this->mail($commentData->email,$url);
                return json_encode(['resultCode'=>'200']);
            }else{
                return json_encode(['resultCode'=>'400']);
            }
        }
        return json_encode(['resultCode'=>'400']);
    }

    /**
     * @param $Mail
     * @param $url
     */
    public function mail($Mail,$url){
        $flag = Mail::send('default/mail',['url'=>$url],function($message) use ($Mail){
            $to=$Mail;
            $message ->to($to)->subject('评论回复');
        });
    }

}