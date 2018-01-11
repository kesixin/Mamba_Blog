<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\System;

class SystemTransformer extends TransformerAbstract
{

    /**
     * @param System $model
     * @return array
     */
    public function transform(System $model)
    {
        return [
            'id ' => (int)$model->id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }


}