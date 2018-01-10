<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 11:13
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Link extends Model implements Transformable
{

    use TransformableTrait;

    protected $fillable = ['name','url','sequence'];

}