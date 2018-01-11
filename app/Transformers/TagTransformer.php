<?php


namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Models\Tag;

class TagTransformer extends TransformerAbstract
{

    /**
     * @param Tag $model
     * @return array
     */
    public function getTransformer(Tag $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];

    }

}