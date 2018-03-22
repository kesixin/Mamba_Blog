<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/22
 * Time: 17:07
 */

namespace App\Repositories;


use Illuminate\Http\Request;
use App\Models\Comment;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


}