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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany('App\Models\Tag','article_tags','article_id','tag_id');
    }

    /**
     * 获得此博客文章的评论
     * Get comments of the article.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

}