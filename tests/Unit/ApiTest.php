<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class ApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function aPi_index_works()
    {
        $this->get('/api/index')
          ->assertStatus(200);
    }
}
