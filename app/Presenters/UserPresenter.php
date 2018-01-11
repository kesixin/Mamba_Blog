<?php

namespace App\Presenters;


use App\Repositories\UserRepositoryEloquent;
use App\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class UserPresenter extends FractalPresenter
{
    protected $user;

    /**
     * UserPresenter constructor.
     * @param UserRepositoryEloquent $user
     */
    public function __construct(UserRepositoryEloquent $user)
    {
        $this->user = $user;
    }

    /**
     * Get Transformer
     * @return UserTransformer
     */
    public function getTransformer()
    {
        // TODO: Implement getTransformer() method.
        return new UserTransformer();
    }

    /**
     * 获取作者信息
     * Get the user info
     * @param int $userId
     * @return mixed
     */
    public function getUserInfo($userId = 0)
    {
        $colums = ['id', 'name', 'user_pic'];

        if ($userId > 0) {
           return $this->user->find($userId, $colums);
        }

        return $this->user->first($colums);
    }

}