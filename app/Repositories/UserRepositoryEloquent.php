<?php


namespace App\Repositories;


use App\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    /**
     * Specify the Model class
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param array $input
     * @param $avatar
     * @return bool
     */
    public function store(array $input, $avatar)
    {
        $attr['email'] = $input['email'];
        $attr['name'] = $input['name'];
        $attr['password'] = bcrypt($input['password']);

        if ($avatar != "") {
            $attr['user_pic'] = $avatar;
        }

        if (parent::create($attr)) {
            return true;
        }

        return false;
    }

    /**
     * @param array $input
     * @param $id
     * @param string $avatar
     * @return bool
     */
    public function update(array $input, $id, $avatar = '')
    {
        $attr['email'] = $input['email'];
        $attr['name'] = $input['name'];
        if ($input['password'] != "") {
            $attr['password'] = bcrypt($input['password']);
        }

        if ($avatar != "") {
            $attr['user_pic'] = $avatar;
        }

        if (parent::update($attr, $id)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     * 获取作者信息
     */
    public function getUserInfo()
    {
        $colums = ['id', 'name', 'user_pic','email'];
        return $this->first($colums);
    }


}