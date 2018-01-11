<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Navigation;

class NavigationTransformer extends TransformerAbstract
{

    /**
     * @param Navigation $model
     * @return array
     */
    public function transform(Navigation $model)
    {
        return [
            'id' => (int) $model->id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

}