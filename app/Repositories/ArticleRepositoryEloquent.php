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
     * 搜索文章
     * @param array $where
     * @return mixed
     */
    public function search(array $where)
    {
        if (count($where) > 0) {
            //将给定的条件应用于模型。
            $this->applyConditions($where);
        }

        return $this->orderBy('id', 'desc')->paginate(15);
    }

    /**
     * 根据关键字搜索文章
     * Search for articles by keyword.
     * @param $keyword
     * @return mixed
     */
    public function searchKeywordArticle($keyword)
    {
        $search = "%" . $keyword . "%";
        $this->applyConditions([['title', 'like', $search]]); //list($field, $condition, $val) = $value;
        return $this->paginate(15, ['id', 'title', 'desc', 'user_id', 'cate_id', 'read_count', 'created_at']);

    }
}