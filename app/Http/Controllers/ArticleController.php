<?php

namespace App\Http\Controllers;


use App\Repositories\ArticleRepositoryEloquent;
use App\Models\Article;

class ArticleController extends Controller
{

    protected $article;

    /**
     * ArticleController constructor.
     * @param ArticleTagRepositoryEloquent $article
     */
    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
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
        return view('default.show_article', compact('article'));
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