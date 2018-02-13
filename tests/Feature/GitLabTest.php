<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route; 
use Tests\Illuminate\Feature\Http;
use App\Http\Controllers\Gitlab;
class GitLabTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
     public function setUp()
    {
        parent::setUp();
           
    }
   

    public function testGetRepos(){
    	  $response = $this->call('GET', '/api/gitlab');
      	  $data = json_encode($response);
            $this->assertIsJson($data);
          $this->assertInternalType('string', $data);
          $this->assertContains($data['data']['data'], 'data');
         $this->assertContains($data , $data['data'][0]['id']);

    }

      public function testGetReposbypages(){
    	  $response = $this->call('GET', 'api/gitlab?page=1');
      	  $data = json_encode($response);
          $this->assertIsJson($data);
           $this->assertInternalType('string', $data);
    }

    
    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error());
    }
}

