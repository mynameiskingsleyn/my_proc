<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use Auth;
use App\User;

class ApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function aPi_index_works()
    {
        $this->get('/api/course')
          ->assertStatus(200);
    }

    /** @test */
    public function users_cannot_view_individual_course_without_token()
    {
        $user = factory('App\User')->create();
        $course = factory('App\Course')->create();
        $cid = $course->uuid;
        $link = '/api/course/show?uuid='.$cid;
        $response = $this->get($link);
        $response->assertStatus(401);
        // save
        $link = '/api/course/save';
        $response = $this->get($link);
        $response->assertStatus(401);
        // update
        $link = '/api/course/update';
        $response = $this->get($link);
        $response->assertStatus(401);
        // delete
        $link = '/api/course/delete';
        $response = $this->get($link);
        $response->assertStatus(401);
        
        $this->be($user);
        $response = $this->get($link);
        $response->assertStatus(401);

        // try random token..
        $api_token ='ab1232abferre';
        $all_users = User::all();
        $link = '/api/course/show?uuid='.$cid.'&api_token='.$api_token;
        $response = $this->get($link);
        $response->assertStatus(401);

        //dd(Auth::user());
    }

    /** @test */
    public function users_with_token_can_access_protected_parts_of_api()
    {
        //protected parts include access to individual courses, updates, save and delete
        $course = factory('App\Course')->create();
        $user = create('App\User');
        $user = tokenizeUser($user); // get token;
        $api_token = $user->api_token;
        $cid = $course->uuid;

        $link = '/api/course/show?uuid='.$cid.'&api_token='.$api_token;
        $response = $this->get($link);
        $response->assertStatus(200);
    }

    /** @test */
    public function logged_in_users_can_also_access_protected_parts_of_api()
    {
        $course = factory('App\Course')->create();
        $cid = $course->uuid;
        $this->signIn();
        $user = Auth::user();
        $api_token = $user->api_token;
        $link = '/api/course/show?uuid='.$cid;
        //$link = '/api/course/show?uuid='.$cid.'&api_token='.$api_token;
        $response = $this->get($link);
        $response->assertStatus(200);
    }
}
