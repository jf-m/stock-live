<?php

namespace Tests\Feature\AlphaVantage;

use App\Apis\AlphaVantage\AlphaVantageMarketValueValidator;
use App\Exceptions\InvalidApiResponseException;
use Tests\TestCase;

class AlphaVantageMarketValueValidatorTest extends TestCase
{
    public function test_it_can_validate_market_value_DTO_from_response(): void
    {
        $this->expectNotToPerformAssertions();
        AlphaVantageMarketValueValidator::validate($this->getMockAlphaVantageData());
    }

    public function test_it_can_throw_exception_when_missing_data_from_alphavantage(): void
    {
        $this->expectException(InvalidApiResponseException::class);
        AlphaVantageMarketValueValidator::validate([
            'Time Series (1min)' => [
                '2024-03-11 19:59:00' => [
                    '1. open' => '192.4000',
                ]]]
        );
    }

    public function test_it_can_throw_exception_when_no_data_from_alphavantage(): void
    {
        $this->expectException(InvalidApiResponseException::class);
        AlphaVantageMarketValueValidator::validate(null);
    }

    public function test_it_can_throw_exception_when_not_float_from_alphavantage(): void
    {
        $this->expectException(InvalidApiResponseException::class);
        AlphaVantageMarketValueValidator::validate([
            'Time Series (1min)' => [
                '2024-03-11 19:59:00' => [
                    '1. open' => 'not-valid-number',
                    '2. high' => '192.5000',
                    '3. low' => '192.4000',
                    '4. close' => '192.5000',
                    '5. volume' => '4',
                ]]]
        );
    }
}
