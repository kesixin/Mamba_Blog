<?php

namespace App\Http\Controllers;


use App\Repositories\ArticleRepositoryEloquent;
use App\Models\Article;
use App\Repositories\CommentRepositoryEloquent;

class ArticleController extends Controller
{

    protected $article;
    protected $comment;

    /**
     * ArticleController constructor.
     * @param ArticleTagRepositoryEloquent $article
     */
    public function __construct(ArticleRepositoryEloquent $article,CommentRepositoryEloquent $comment)
    {
        $this->article = $article;
        $this->comment = $comment;
    }

    /**
     * 显示文章详情
     * Display article.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $article = $this->article->find($id);
        $article->read_count = $article->read_count + 1;
        $article->save();
        $comments= $article->comments()->where('parent_id', 0)->orderBy('created_at', 'desc')->get();
        for ($i=0; $i < sizeof($comments); $i++) {
            $comments[$i]->created_at_diff = $comments[$i]->created_at->diffForHumans();
            $comments[$i]->avatar_text = mb_substr($comments[$i]->name,0,1,'utf-8');
            $replys = $comments[$i]->replys;
            for ($j=0; $j < sizeof($replys); $j++) {
                $replys[$j]->created_at_diff = $replys[$j]->created_at->diffForHumans();
                $replys[$j]->avatar_text = mb_substr($replys[$j]->name,0,1,'utf-8');
            }
        }
        return view('default.show_article', compact('article','comments'));
    }

    /**
     * 归档查询列表
     * Select the articles by Date.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selectDate()
    {
        $articles=[];
        $years=[];
        $archives = $this->article->selectDate();
        foreach ($archives as $key=>$value){
            $archives[$key]['articles'] = $this->article->selectByDate($value['year'],$value['month']);
            $years[]=$value['year'];
        }
        $years=array_unique($years);
        return view('default.date_article',compact('archives','years'));
    }

}