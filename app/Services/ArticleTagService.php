<?php


namespace App\Services;


use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\ArticleTagRepositoryEloquent;
use App\Repositories\TagRepositoryEloquent;

class ArticleTagService
{
    protected $tags;
    protected $articleTags;

    /**
     * ArticleTagService constructor.
     * @param TagRepositoryEloquent $tag
     * @param ArticleTagRepositoryEloquent $articleTag
     */
    public function __construct(TagRepositoryEloquent $tag, ArticleTagRepositoryEloquent $articleTag)
    {
        $this->tags = $tag;
        $this->articleTags = $articleTag;
    }

    /**
     * 写入文章标签
     * Store a newly created resource in storage.
     * @param $articleId
     * @param $tagNameString
     * @return bool
     */
    public function store($articleId, $tagNameString)
    {
        if ($tagNameString == "") {
            return false;
        }

        $tagNameList = array_unique(explode(';', trim($tagNameString, ';')));

        if (!$tagNameList) {
            return false;
        }

        foreach ($tagNameList as $tagName) {
            $tagData = $this->tags->findName($tagName);
            $create = [];
            $create['tag_id'] = count($tagData) > 0
                ? $tagData['id']
                : $this->tags->create(['tag_name' => $tagName])->id;
            $create['article_id'] = $articleId;
            $this->articleTags->create($create);
        }

        return true;

    }

    public function updateArticleTags($articleId,$tagNameString)
    {
        $this->articleTags->getModel()->where('article_id',$articleId)->delete();
        return $this->store($articleId,$tagNameString);
    }

    /**
     * 获取文章标签ID
     * Get the tag's ID of the article
     * @param $tags
     * @param bool $type
     * @return array|string
     */
    public function tagsIdList($tags, $type = true)
    {
        $tagIdList = [];
        foreach ($tags as $tag){
            $tagIdList[]=$tag->tag_id;
        }

        return $type ? $tagIdList : implode(',',$tagIdList);
    }

}