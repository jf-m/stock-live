<?php

namespace App\Http\Transformers;

use Illuminate\Support\Collection;

abstract class BaseTransformer
{
    /**
     * @param  Collection<int, mixed>  $collection
     * @return array<string, mixed>
     */
    public function transformCollection(Collection $collection): array
    {
        return $collection->map(fn (mixed $value) => $this->transform($value))->toArray();
    }

    /**
     * @return array<string, mixed>
     */
    abstract public function transform(mixed $value): array;
}
