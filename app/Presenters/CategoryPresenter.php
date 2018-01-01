<?php


namespace App\Presenters;


use App\Repositories\CategoryRepositoryEloquent;
use Prettus\Repository\Presenter\FractalPresenter;

class CategoryPresenter extends FractalPresenter
{

    protected $category;

    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category=$category;
        parsent::__construct();
    }

    public function getTransformer()
    {
        return new CategoryTransformer();
    }

}