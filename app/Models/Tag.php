<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Tag extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * Allow operation fields
     * 允许操作字段
     * @var array
     */
    protected $fillable = ['tag_name', 'article_number'];

    protected $table='tags';

}