<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 11:11
 */

namespace App\Repositories;


use App\Models\Link;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LinkRepository;

class LinkRepositoryEloquent extends BaseRepository implements LinkRepository
{

    /**
     * Specify the Model class name
     * @return string
     */
    public function model()
    {
        return Link::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}