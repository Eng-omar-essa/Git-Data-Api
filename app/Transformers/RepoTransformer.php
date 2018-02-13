<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\BaseTransformer;
use App\Repos;

/**
* @transformer \Mpociot\ApiDoc\Tests\Fixtures\TestTransformer
**/
class RepoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($collection)
    {
        return [
            'id' => (string)$collection['id'],
            'repo_name'=>(string)$collection['repo_name'],
            'owner'=>(object)$collection['owner'],
            'stars' => (int)'stars', 
        ];
    }

          public static function originalAttribute($index)
        {
            $attributes = [
                'id' => 'id',
                'repo_name' => 'repo_name',
                'owner' => 'owner',
                'stars' => 'stars',
            ];

            return isset($attributes[$index]) ? $attributes[$index] : null;
        }

        public static function transformedAttribute($index)
        {
            $attributes = [
                'id' => 'id',
                'repo_name' => 'repo_name',
                'owner' => 'owner',
                'stars' => 'stars',
            ];

            return isset($attributes[$index]) ? $attributes[$index] : null;
        }
}
