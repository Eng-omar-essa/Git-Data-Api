<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data) use ($factory) {
            $repos = [];
            $repo_info;
            foreach ($data as $repo) {
                
                $repo_info['repo_name'] = $repo['name'];
                $repo_info['owner']= $repo['owner'];
                $repo_info['files'] = $repo['name'];
                array_push($repos,$repo_info);
            }
            $customFormat = [
                'success' => true,
                'data' => $repos
            ];
            return $factory->make($customFormat);
        });
    }

    public function register()
    {
        //
    }
}