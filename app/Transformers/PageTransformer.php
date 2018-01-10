<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:59
 */

namespace App\Transformers;

use App\Models\Page;
use League\Fractal\TransformerAbstract;

/**
 * Class PageTransformer
 * @package App\Transformers
 */
class PageTransformer extends TransformerAbstract
{

    /**
     * @param Page $model
     * @return array
     */
    public function transform(Page $model)
    {
        return [
            'id' => (int) $model->id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}