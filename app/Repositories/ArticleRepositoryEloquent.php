<?php


namespace App\Repositories;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
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
        return $this->paginate(15, ['id', 'title', 'desc', 'user_id', 'cate_id', 'read_count', 'created_at','list_pic']);

    }

    /**
     * 查询文章发布日期（年月）
     * @return mixed
     */
    public function selectDate()
    {
//        $archives = Article::selectRaw('year(created_at)  year, month(created_at) month, count(*) count')
//            ->groupBy('year', 'month')
//            ->orderByRaw('min(created_at) desc')
//            ->get();
//        return $archives;
        $articles=DB::select("select `id`,`title`,`created_at` from `articles` ORDER BY `id` desc");
        return $articles;
    }

    /**
     * 按照日期查询文章
     * Select the articles by Date.
     * @param $year
     * @param $month
     * @return mixed
     */
    public function selectByDate($year, $month)
    {
        if ($month < 10) {
            $month = '0' . $month;
        }

        $articles=DB::select("select `id`,`title`,`created_at` from `articles` where date_format(created_at,'%Y%m') =".$year.$month);
        return $articles;
    }
}