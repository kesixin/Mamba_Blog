<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 21:20
 */

namespace App\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Category extends Node implements Transformable
{

    use TransformableTrait;

    protected $fillable=[];

    protected $table='categories';

    /**
     * 文章与分类为一对一关联
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function article()
    {
        return $this->hasOne('App\Models\Article','cate_id','id');
    }
}