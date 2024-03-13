<?php

namespace App\Apis\DTO;

use Carbon\Carbon;

/**
 * DTO Object used to carry data between third party API (Alpha Vantage) and services in this app.
 *
 */
class MarketValueDTO implements \JsonSerializable
{
    public function __construct(
        public float $open,
        public float $high,
        public float $low,
        public float $close,
        public int $volume,
        public Carbon $timestamp
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'open' => $this->open,
            'high' => $this->high,
            'low' => $this->low,
            'close' => $this->close,
            'volume' => $this->volume,
            'interval_time' => $this->timestamp,
        ];
    }
}
