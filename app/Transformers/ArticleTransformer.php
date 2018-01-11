<?php

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Models\Article;

class ArticleTransformer extends TransformerAbstract
{

    /**
     * @param Article $model
     * @return array
     */
    public function getTransformer(Article $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

}