<?php

namespace App\Http\Controllers\GitHub;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Input;
use App\Repos;
/**
* @resource GithubController
* @author Omar Issa, 
*
*/
class GitHubController extends ApiController
{
/**
* This GitHubController , it is used to to get all repos form git hub account , if account * not exisit in env configuration it view public repo. 
* 
*/

   private $client;
    /*
     * Github username
     *
     * @var string
     * */
    private $username;


    public function __construct(\Github\Client $client)
    {
      $this->client = $client;
      $this->username = env('GITHUB_USERNAME');
  }
      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
        $repos_ =[];
        
        try {
          if($this->username != ""){
        
            $repos_ = $this->client->api('current_user')->repositories();
          }else{
             $repos_ = $this->client->api('repo')->all();
          }
          
          $repos = Repos::Repo_info($repos_);

          return $this->showAll(collect($repos));
          } catch (\RuntimeException $e) {
            $this->handleAPIException($e);
       }
    }

    public function getFiles($repo)
      {       
          try { 
            $fileExists = $this->client->api('repo')->contents()->exists($this->username,$repo,$path=null);
            if($fileExists){
                $result = $this->client->api('repo')->contents()->show($this->username,$repo);

            }else {
              $result = Null;
            }
          
          return $this->showall(collect($result));
         
        } catch (\RuntimeException $e) {
            $this->handleAPIException($e);
          
        }
    }


}
