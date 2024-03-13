<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $stock_id
 * @property float $open
 * @property float $high
 * @property float $low
 * @property float $close
 * @property float $volume
 * @property Carbon $interval_time
 * @property Stock $stock
 * */
class MarketValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stock_id',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'interval_time',
    ];

    public $timestamps = false;

    /**
     * @return BelongsTo<Stock, MarketValue>
     */
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * @return array<string,string>
     */
    protected function casts(): array
    {
        return [
            'interval_time' => 'datetime',
            'open' => 'float',
            'high' => 'float',
            'low' => 'float',
            'close' => 'float',
            'volume' => 'integer',
        ];
    }

    public function getPercentageChange(): float
    {
        return floor(((($this->close - $this->open) / $this->open) * 100) * 100) / 100;
    }
}
