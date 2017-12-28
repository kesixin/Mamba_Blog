<?php


namespace App\Repositories;

use App\Models\Article;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\ArticleRepository;


/**
 * Class ArticleRepositoryEloquent
 * @package App\Repositories
 */
class ArticleRepositoryEloquent extends BaseRepository implements ArticleRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }


    /**
     *
     */
    public function search(array $where)
    {
        if(count($where) > 0){
            //将给定的条件应用于模型。
            $this->applyConditions($where);
        }

        return $this->orderBy('id','desc')->paginate(15);
    }
}