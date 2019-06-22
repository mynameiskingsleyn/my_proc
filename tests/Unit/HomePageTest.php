<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class HomepageTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_is_redirected_to_login_upon_page_visit()
    {
        $this->get('/')
          ->assertStatus(302); //redirect to login
    }

    /** @test */
    public function a_user_can_visit_home_page_if_loggedin()
    {
        $user = create('App\User');
        $this->be($user);
        $this->get('/')
          ->assertStatus(200);
    }
}
