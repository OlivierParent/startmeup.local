<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as TestCaseBase;

class TestCase extends TestCaseBase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://startmeup.arteveldehogeschool.local';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
