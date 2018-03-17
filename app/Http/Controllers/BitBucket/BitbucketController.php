<?php

namespace App\Http\Controllers\BitBucket;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use GrahamCampbell\Bitbucket\BitbucketManager;
use GrahamCampbell\Bitbucket\Facades\Bitbucket;
use Illuminate\Support\Facades\App;
use App\Repos;

class BitbucketController extends ApiController
{

	protected $bitbucket;

    public function __construct(BitbucketManager $bitbucket)
    {
        $this->bitbucket = $bitbucket;
        Bitbucket::connection('alternative')->api('User')->emails();
    }


    public function index()
    {
    	$repos_ = new Repos();

    	try {
    		// $this->bitbucket->Bitbucket::connection('alternative')->api('User')->emails();
    		$repos =  $this->bitbucket->api('Repositories\Repository')->get('gentlero', 'bitbucket-api', 2);
    		return $this->showAll(collect($repos));

    	} catch (\RuntimeException $e) {
    		$this->handleAPIException($e);
    	}
    }
}
