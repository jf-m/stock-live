<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property Collection<MarketValue> $marketValues
 */
class Stock extends Model
{
    use HasFactory;

    const int LIMIT_HISTORY_MARKET_VALUE = 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'symbol',
    ];

    /**
     * @return HasMany<MarketValue>
     */
    public function marketValues(): HasMany
    {
        return $this->hasMany(MarketValue::class)->limit(self::LIMIT_HISTORY_MARKET_VALUE);
    }

    /**
     * Get the user's most recent order.
     */
    public function getLatestMarketValue(): ?MarketValue
    {
        return \Cache::remember($this->getLatestPriceCacheKeyName(), 60, function () {
            return MarketValue::where('stock_id', $this->id)
                ->where('interval_time', MarketValue::where('stock_id', $this->id)->max('interval_time'))
                ->first();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'symbol';
    }

    public function getLatestPriceCacheKeyName(): string
    {
        return 'lp_'.$this->id;
    }

    public function forgetLatestPriceCache(): void
    {
        \Cache::forget($this->getLatestPriceCacheKeyName());
    }
}
