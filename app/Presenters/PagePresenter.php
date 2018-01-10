<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:57
 */

namespace App\Presenters;


use App\Transformers\PageTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class PagePresenter extends FractalPresenter
{

    /**
     * @return PageTransformer
     */
    public function getTransformer()
    {
        return new PageTransformer();
    }

    /**
     * @param $id
     * @param $alias
     * @return string
     */
    public function getLink($id,$alias)
    {
        if($alias == 'about'){
            return route('about');
        }

        $alias = $alias !="" ? $alias : $id;

        return route('page.show',['alias'=>$alias]);
    }

}