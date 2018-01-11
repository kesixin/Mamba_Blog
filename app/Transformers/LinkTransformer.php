<?php


namespace App\Transformers;


use App\Models\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{

    /**
     * @param Link $model
     * @return array
     */
    public function getTransformer(Link $model)
    {
        return [
            'id' => (int)$model->id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

}