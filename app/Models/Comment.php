<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Comment extends Model implements Transformable
{

    use TransformableTrait;

    protected $table='comments';

    protected $fillable=['user_id', 'article_id', 'parent_id', 'content', 'name', 'email', 'website', 'avatar', 'ip', 'city','target_name'];

    /**
     * 获得此评论所属的文章
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    public function replys()
    {
        return $this->hasMany('App\Models\Comment','parent_id');
    }
}