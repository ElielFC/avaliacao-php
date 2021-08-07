<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected static $setUpHasRunOnce = false;

    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        if(!static::$setUpHasRunOnce) {

            $this->artisan('config:cache --env=testing');
            $this->artisan('migrate:fresh', ['-vvv' => true]);
            $this->artisan('db:seed', ['-vvv' => true]);

            static::$setUpHasRunOnce = true;
        }
    }
}
