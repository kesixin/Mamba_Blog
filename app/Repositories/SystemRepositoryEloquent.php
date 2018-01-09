<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 23:00
 */

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SystemRepository;

class SystemRepositoryEloquent extends BaseRepository implements SystemRepository
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return System::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}