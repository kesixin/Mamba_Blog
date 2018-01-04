<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4
 * Time: 15:58
 */

namespace App\Presenters;


use App\Repositories\TagRepositoryEloquent;
use Prettus\Repository\Presenter\FractalPresenter;

class TagPresenter extends FractalPresenter
{
    protected $tag;

    public function __construct(TagRepositoryEloquent $tag)
    {
        $this->tag = $tag;
        parent::__construct();
    }

    /**
     * @return TagTransformer
     */
    public function getTransformer()
    {
        return new TagTransformer();
    }

    public function tagNameList($idList)
    {
        $tagName = "";
        if ($idList != "") {
            $tags = $this->tag->findWhereIn('id',explode(',',$idList),['tag_name']);
            if($tags){
                foreach ($tags as $tag){
                    $tagName .= $tag->tag_name . ";";
                }
            }
        }
        return $tagName;
    }


}