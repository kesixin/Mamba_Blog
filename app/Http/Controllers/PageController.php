<?php

namespace App\Http\Controllers;

use App\Repositories\PageRepositoryEloquent;
use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{
    protected $page;

    /**
     * PageController constructor.
     * @param PageRepositoryEloquent $page
     */
    public function __construct(PageRepositoryEloquent $page)
    {
        $this->page = $page;
    }

    public function index($alias)
    {
        $page = $this->page->getAliasInfo($alias);

        if(!$page){
            abort(404);
        }

        return view('default.show_page', compact('page'));
    }

    /**
     * 关于页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $page = $this->page->aboutInfo('about');

        if (!$page) {
            abort(404);
        }

        return view('default.show_page', compact('page'));
    }
}
