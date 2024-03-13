<?php

namespace Tests\Unit;

use App\Apis\DTO\MarketValueDTO;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class MarketValueDTOTest extends TestCase
{
    public function test_it_can_be_json_serialized(): void
    {
        $marketValue = new MarketValueDTO(
            192.5000,
            192.5000,
            192.5000,
            192.5000,
            11,
            Carbon::parse('2024-03-11 19:59:00')
        );
        $this->assertEquals(json_encode($marketValue), '{"open":192.5,"high":192.5,"low":192.5,"close":192.5,"volume":11,"interval_time":"2024-03-11T19:59:00.000000Z"}');
    }
}
