<?php

namespace App\Apis\AlphaVantage;

use App\Exceptions\InvalidApiResponseException;
use Illuminate\Support\Facades\Validator;

class AlphaVantageMarketValueValidator
{
    /**
     * @param  array<string, mixed>|null  $jsonResponse
     * @return array<string, mixed>
     *
     * @throws InvalidApiResponseException
     */
    public static function validate(?array $jsonResponse): array
    {
        $jsonList = $jsonResponse['Time Series (1min)'] ?? null;

        if (! $jsonResponse ||
            ! $jsonList) {
            throw new InvalidApiResponseException($jsonResponse['Information'] ?? json_encode($jsonResponse));
        }

        foreach ($jsonList as $timestamp => $rawMarketValue) {
            $validator = Validator::make($rawMarketValue, [
                '1\. open' => 'required|decimal:4',
                '2\. high' => 'required|decimal:4',
                '3\. low' => 'required|decimal:4',
                '4\. close' => 'required|decimal:4',
                '5\. volume' => 'required|integer',
            ]);
            if ($validator->fails()) {
                throw new InvalidApiResponseException($validator->errors()->toJson());
            }
        }

        return $jsonResponse;
    }
}
