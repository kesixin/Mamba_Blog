<?php

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

    /**
     * @param $idList
     * @return string
     */
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

    /**
     * @return mixed
     */
    public function tagList()
    {
       $tagList = $this->tag->all(['id', 'tag_name']);
       return $tagList;
    }


}