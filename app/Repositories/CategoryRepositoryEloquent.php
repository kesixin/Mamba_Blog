<?php

namespace App\Repositories;


use App\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\CategoryRepository;

class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{

    /**
     * Specify model class name
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function getNestedList()
    {
        return $this->model->getNestedList('name', null, '&nbsp;&nbsp;&nbsp;&nbsp;');
    }

}