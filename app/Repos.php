<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\ReposTrasformer;

class Repos extends Model
{
    
    public $transformer = ReposTrasformer::class; 
    protected $fillable = [
       'id', 'repo_name', 'owner', 'stars',
    ];

    protected function Repo_info($data){
   			$repos = array();
            $repo_info;
            foreach ($data as $repo) {
                $repo_info['id'] = $repo['id'];
                $repo_info['repo_name'] = $repo['name'];
                $repo_info['owner']= $repo['owner'];
                $repo_info['stars']=isset($repo['stargazers_count']) ; null;
                array_push($repos,$repo_info);
            }
            
            return $repos;
        }

}

