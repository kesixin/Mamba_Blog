<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:29
 */

namespace App\Repositories;


use App\Models\Page;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PageRepository;

/**
 * Class PageRepositoryEloquent
 * @package App\Repositories
 */
class PageRepositoryEloquent extends BaseRepository implements PageRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Page::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function aboutInfo($alias)
    {
        $where['link_alias'] = $alias;
        $this->applyConditions($where);
        return $this->first();
    }

    /**
     * @param $alias
     * @return bool|mixed
     */
    public function getAliasInfo($alias)
    {
        if(is_numeric($alias) && $alias>0){
            return $this->find($alias);
        }

        if($alias !=""){
            return $this->aboutInfo($alias);
        }

        return false;
    }

}