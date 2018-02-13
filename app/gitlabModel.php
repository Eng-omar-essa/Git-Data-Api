<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\GitLabTransformer;
class gitlabModel extends Model
{
   

   public $transformer = GitLabTransformer::class; 

    protected $fillable = [
       'id', 'repo_name', 'links', 'description', 'stars'
    ];


    protected function Repo_info($data){
   			$repos = [];
            $repo_info;
            foreach ($data as $repo) {
                $repo_info['id'] = $repo['id'];
                $repo_info['repo_name'] = $repo['name'];
                $repo_info['links']= $repo['_links'];
                $repo_info['description'] = $repo['description'];
                $repo_info['stars'] = $repo['star_count'];
                array_push($repos,$repo_info);
            }
            
            return $repos;
        }
    }
