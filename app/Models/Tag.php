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

    /**
     * 文章与标签多对多关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function article()
    {
        return $this->belongsToMany('App\Models\Article','article_tags','tag_id','article_id');
    }

}