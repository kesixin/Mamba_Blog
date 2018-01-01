<?php


namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\TagRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Tag;

class TagRepositoryEloquent extends BaseRepository implements TagRepository
{

    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}