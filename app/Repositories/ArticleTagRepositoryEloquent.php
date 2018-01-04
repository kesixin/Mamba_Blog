<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4
 * Time: 11:05
 */

namespace App\Repositories;


use App\Models\ArticleTag;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class ArticleTagRepositoryEloquent extends BaseRepository implements ArticleTagRepository
{

    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return ArticleTag::class;
    }

    /**
     *
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getModel()
    {
        return $this->model;
    }
}