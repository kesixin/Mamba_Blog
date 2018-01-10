<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:33
 */

namespace App\Models;


use Baum\Extensions\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Page extends Model implements Transformable
{

    use TransformableTrait;

    protected $guarded = ['id'];

}