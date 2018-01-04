<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Article extends Model implements Transformable
{

    use TransformableTrait;

    protected $table='articles';

    protected $guarded=['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category','cate_id');
    }

    /**
     * 文章标签
     * Article tags
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleTag()
    {
        return $this->hasMany('App\Models\ArticleTag','article_id','id');
    }

}