<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Article extends Model implements Transformable
{

    use TransformableTrait;

    protected $table='articles';

//    public function user()
//    {
//        return $this->belongsTo('App\User','user_id');
//    }

}