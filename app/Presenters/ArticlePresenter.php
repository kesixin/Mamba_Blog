<?php


namespace App\Presenters;


use App\Repositories\ArticleTagRepositoryEloquent;
use Prettus\Repository\Presenter\FractalPresenter;

class ArticlePresenter extends FractalPresenter
{
    protected $article;

    public function __construct(ArticleTagRepositoryEloquent $article)
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

}