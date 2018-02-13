<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Github;
use Illuminate\Support\Facades\Route;
class GithubTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    //   public function setUp()
    // {
    //     parent::setUp();
    //     // Route::enableFilters();
       
    // }
   

    public function testGetRepos(){
    	  $response = $this->call('GET','api/github');
    	  $data = json_encode($response);
    	  // print_r($data);
          $this->assertIsJson($data);
          $this->assertInternalType('string', $data);
          $this->assertContains($data['data']['data'], 'data');
         $this->assertContains($data , $data['data'][0]['id']);
    }

     public function testGetReposbypages(){
    	  $response = $this->get('api/gitHub?page=1');
    	  $data = json_encode($response);
          $this->assertIsJson($data);
           $this->assertInternalType('string', $data);
        
          
     }

    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error());
    }
}
