<?php

namespace App\Models\Casts\Order;

use App\Models\Enums\Order\OrderStatusEnum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class OrderStatusEnumCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return OrderStatusEnum::from($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof OrderStatusEnum) {
            return $value->value;
        }

        if (is_string($value)) {
            return $value;
        }

        throw new InvalidArgumentException('Invalid status value');
    }
}
