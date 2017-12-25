<?php

namespace App\Presenters;

use Route;

class BackendPresenter
{
    private $route;

    public function menu()
    {
        $this->route = Route::currentRouteName();
        $menu=config('blog.menu');

        $menuString='';
        foreach ($menu as $mList){
            $count = count($mList);
            if($count>1){
                $menuString .=$this->childrenShow($mList);
            }else{
                $menuString .=$this->parentShow($mList);
            }
        }

        return $menuString;
    }


    /**
     * @param $menu
     * @return string
     */
    private function childrenShow($menu)
    {

    }

    /**
     * @param $menu
     * @return string
     */
    private function parentShow($menu)
    {
        $string = '';
        foreach ( $menu as $route => $m) {
            $string.="<li class='treeview ".$this->active($route)."'>
                <a href='".route($route)."'>
                    <i class='".$m['icon']."'></i>
                    <span>".$m['name']."</span>
                </a>
            </li>";
        }

        return $string;
    }

    private function active($route)
    {
        return $this->route == $route ? 'active' : '';
    }
}