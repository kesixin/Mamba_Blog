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

    /**
     * @return mixed
     */
    public function getNestedList()
    {
        return $this->model->getNestedList('name', null, '&nbsp;&nbsp;&nbsp;&nbsp;');
    }

    /**
     * Store a newly resource.
     * @param $input
     * @return bool
     */
    public function store($input)
    {
        if ($input['cate_id'] == 0) {
            return $this->model->create(['name' => $input['name']]) ? true : false;
        }

        $category = $this->model->find($input['cate_id']);

        if (!$category) {
            return false;
        }

        return $category->children()->create(['name' => $input['name']]) ? true : false;
    }

    public function update(array $attributes, $id)
    {
        $input['name'] = $attributes['name'];
        $parentId = $attributes['cate_id'];

        $category = $this->model->find($id);
        if(!$category){
            return false;
        }

        return true;
    }

}