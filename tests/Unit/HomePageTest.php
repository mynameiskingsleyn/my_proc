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
    public function home_page_works()
    {
        $this->get('/')
          ->assertStatus(200);
    }
}
