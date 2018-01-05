<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/5
 * Time: 14:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Navigation extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable=['name','url','sequence','state','article_cate_id','nav_type'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category','article_cate_id','id');
    }
}