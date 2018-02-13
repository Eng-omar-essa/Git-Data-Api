<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transformers\GitLabTransformer;

/**
* @transformer \Mpociot\ApiDoc\Tests\Fixtures\TestTransformer
**/
class GitLabTransformer extends TransformerAbstract
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
            'links'=>(object)$collection['links'],
            'description'=>(string)$collection['description'],
            'stars' => (int)'stars', 
        ];
    }

          public static function originalAttribute($index)
        {
            $attributes = [
                'id' => 'id',
                'repo_name' => 'repo_name',
                'links' => 'links',
                'description'=>'description',
                'stars' => 'stars',
            ];

            return isset($attributes[$index]) ? $attributes[$index] : null;
        }

        public static function transformedAttribute($index)
        {
            $attributes = [
                'id' => 'id',
                'repo_name' => 'repo_name',
                'links' => 'links',
                'description'=>'description',
                'stars' => 'stars',
            ];

            return isset($attributes[$index]) ? $attributes[$index] : null;
        }
}
