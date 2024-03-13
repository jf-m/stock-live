<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function getMockAlphaVantageData(): array
    {
        return json_decode(file_get_contents(base_path('tests/data/intraday-compact.json')), true);
    }
}
