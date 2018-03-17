<?php

namespace App\Http\Controllers\GitLab;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Vinkla\GitLab\Facades\GitLab;
use Vinkla\GitLab\GitLabManager;
use App\Repos;
use App\gitlabModel;
/**
* @resource GitController
* @author Omar Issa
*/

class GitController extends ApiController
{
    //
     private $gitlab;
     public function __construct(GitLabManager $gitlab)
    {
        $this->gitlab = $gitlab;
    }

    public function index(){
    	$repos_ =[];
    	try{
    	$repos_ =$this->gitlab->api('projects')->all();
    	$repos = gitlabModel->Repo_info($repos_);
       return $this->showAll(collect($repos));
     	} catch (\RuntimeException $e) {
            $this->handleAPIException($e);
       }

    }

    public function get_files($id){

    	try{
    	$repos =$this->gitlab->api('repo')->getFile($id,'.','master');

    	if($repos == Null){
    		return $this->errorResponse(collect($repos));
    	}
       return $this->showAll(collect($repos));
    	} catch (\RuntimeException $e) {
            $this->handleAPIException($e);

       }
    }

	     public function show($id)
	    {
	    	try{
	    		$repos =$this->gitlab->api('projects')->show($id);
	    	return $this->showAll(collect($repos));
	    } catch (\RuntimeException $e) {
	            $this->handleAPIException($e);
	       }
	   }

}
