<?php

namespace App\Presenters;


use App\Repositories\SystemRepositoryEloquent;
use App\Transformers\SystemTransformer;
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
        parent::__construct();
    }

    /**
     * Get Transformer
     * @return SystemTransformer
     */
    public function getTransformer()
    {
        // TODO: Implement getTransformer() method.
        return new SystemTransformer();
    }

    /**
     * 根据key获取value
     * Get the specified value.
     * @param $key
     * @return bool
     */
    public function getKeyValue($key)
    {
        return isset($this->list[$key]) ? $this->list[$key] : "";
    }

}