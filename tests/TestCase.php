<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        $user = $user ?: create('App\User');
        $user->generateToken();
        $this->actingAs($user);
        return $this;
    }
}
