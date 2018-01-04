<?php


namespace App\Repositories;


use Prettus\Repository\Contracts\RepositoryInterface;

interface ArticleTagRepository extends RepositoryInterface
{

    public function getModel();
}