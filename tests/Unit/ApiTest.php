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
use App\Course;

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
    public function users_cannot_access_protected_parts_of_api_without_token_or_signin()
    {
        $user = factory('App\User')->create();
        $course = factory('App\Course')->create();
        //dd($course);
        $cid = $course->uuid;
        $link = '/api/course/show?uuid='.$cid;
        $response = $this->get($link);
        $response->assertStatus(401);
        $course2 = factory('App\Course')->make();
        // try random token..
        $api_token ='ab1232abferre';
        $all_users = User::all();
        $link = '/api/course/show?uuid='.$cid.'&api_token='.$api_token;
        $response = $this->get($link);
        $response->assertStatus(401);

        // save
        $data = $course2->toArray();
        $link = '/api/course/save';
        $response = $this->post($link, $data);
        $response->assertStatus(401);

        $latest_course = Course::latest()->first();
        $data = $latest_course->toArray();
        $data['name']='Changed name';
        // update
        $link = '/api/course/update';
        $response = $this->put($link, $data);
        $response->assertStatus(401);
        // delete
        $link = '/api/course/delete';
        $response = $this->delete($link, $data);
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
    public function logged_in_users_can_also_access_protected_parts_of_api()//Read
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

    /** @test */
    public function authorized_user_can_delete_a_course_on_protected_api()//delete
    {
        $this->signIn();
        $course = factory('App\Course')->create();
        $check = ['uuid'=>$course->uuid,'name'=>$course->name, 'description'=>$course->description];
        $this->assertDatabaseHas('courses', $check);
        // delete item..
        $link = '/api/course/delete';
        $response = $this->delete($link, $check);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('courses', $check);
    }

    /** @test */
    public function authorized_user_can_update_a_course_on_protected_api()//update
    {
        $this->signIn();
        $course = factory('App\Course')->create();
        $check = ['uuid'=>$course->uuid,'name'=>$course->name,'code'=>$course->code,
        'status'=>$course->status, 'description'=>$course->description];
        $this->assertDatabaseHas('courses', $check);
        //update item ....
        $check['name']='a new name';
        $this->assertDatabaseMissing('courses', $check);
        $link = '/api/course/update';
        $response = $this->put($link, $check);
        $response->assertStatus(200);
        $this->assertDatabaseHas('courses', $check);
    }

    /** @test */
    public function authorized_user_can_create_a_course_on_protected_api()//create
    {
        $this->signIn();
        $course = factory('App\Course')->make();
        $data = $course->toArray();
        $check =['name'=>$course->name,'description'=>$course->description,'status'=>$course->status,'code'=>$course->code];
        $this->assertDatabaseMissing('courses', $check);
        $link = '/api/course/save';
        //save course.
        $this->post($link, $data)
              ->assertStatus(201);

        $this->assertDatabaseHas('courses', $check);
    }
}
