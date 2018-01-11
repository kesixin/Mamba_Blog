<?php

namespace App\Http\Controllers;


use App\Repositories\TagRepositoryEloquent;

class TagController extends Controller
{

    protected $tag;

    /**
     * TagController constructor.
     * @param TagRepositoryEloquent $tag
     */
    public function __construct(TagRepositoryEloquent $tag)
    {
        $this->tag = $tag;
    }

    public function index($id)
    {
        $tag = $this->tag->find($id);
        $articles = $tag->article()
            ->orderby('sort', 'desc')
            ->orderby('id', 'desc')
            ->paginate(15);
        return view('default.tag_article', compact('articles', 'tag'));

    }

}