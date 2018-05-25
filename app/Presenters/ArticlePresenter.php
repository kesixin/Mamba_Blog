<?php


namespace App\Presenters;


use App\Repositories\ArticleRepositoryEloquent;
use Prettus\Repository\Presenter\FractalPresenter;

class ArticlePresenter extends FractalPresenter
{
    protected $article;

    public function __construct(ArticleRepositoryEloquent $article)
    {
        $this->article = $article;
        parent::__construct();
    }

    /**
     * @return ArticleTransformer
     */
    public function getTransformer()
    {
        return new ArticleTransformer();
    }

    /**
     * Format the article's title.
     * @param $title
     * @return string
     */
    public function formatTitle($title)
    {
        if (strlen($title) <= 20) {
            return $title;
        } else {
            return mb_substr($title, 0, 20, 'utf-8') . "...";
        }
    }

    /**
     * 获取热门文章
     * @return mixed
     */
    public function hotArticleList()
    {
        $hostArticleList = $this->article
            ->orderBy('read_count','desc')
            ->paginate(5,['id','title','read_count','created_at','list_pic']);

        return $hostArticleList;
    }

}