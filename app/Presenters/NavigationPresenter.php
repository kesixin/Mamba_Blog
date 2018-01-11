<?php

namespace App\Presenters;


use App\Repositories\NavigationRepositoryEloquent;
use App\Transformers\NavigationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class NavigationPresenter extends FractalPresenter
{

    protected $navigation;

    /**
     * NavigationPresenter constructor.
     * @param NavigationRepositoryEloquent $navigation
     */
    public function __construct(NavigationRepositoryEloquent $navigation)
    {
        $this->navigation = $navigation;
        parent::__construct();
    }

    /**
     * Get Transformer
     * @return NavigationTransformer
     */
    public function getTransformer()
    {
        return new NavigationTransformer();
    }

    /**
     * 获取导航列表
     * Get the list of the navigation
     * @return mixed
     */
    public function getNavList()
    {
        $navigations = $this->navigation->orderBy('sequence', 'desc')->findWhere(['state' => 0], ['name', 'url']);
        return $navigations;
    }

}