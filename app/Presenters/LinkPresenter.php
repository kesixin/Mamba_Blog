<?php

namespace App\Presenters;


use App\Repositories\LinkRepositoryEloquent;
use App\Transformers\LinkTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class LinkPresenter extends FractalPresenter
{
    protected $link;

    /**
     * LinkPresenter constructor.
     * @param LinkRepositoryEloquent $link
     */
    public function __construct(LinkRepositoryEloquent $link)
    {
        $this->link = $link;
        parent::__construct();
    }

    /**
     * @return LinkTransformer
     */
    public function getTransformer()
    {
        // TODO: Implement getTransformer() method.
        return new LinkTransformer();
    }

    /**
     * 获取友情链接
     * Get the listing of the link.
     * @return mixed
     */
    public function linkList()
    {
        $links = $this->link->orderBy('sequence', 'desc')->all(['name', 'url']);
        return $links;
    }

}