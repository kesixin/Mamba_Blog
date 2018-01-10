<?php

namespace App\Presenters;


use App\Repositories\SystemRepositoryEloquent;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SystemPresenter
 * @package App\Presenters
 */
class SystemPresenter extends FractalPresenter
{

    protected $system;
    protected $list;

    public function __construct(SystemRepositoryEloquent $system)
    {
        $this->system = $system;
        $this->list = $this->system->optionList();
        parsent::construct();
    }

    public function getTransformer()
    {
        // TODO: Implement getTransformer() method.
    }

}