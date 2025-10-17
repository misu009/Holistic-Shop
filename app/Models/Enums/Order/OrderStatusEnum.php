<?php

namespace App\Models\Enums\Order;

use Spatie\Enum\Enum;

/**
 * @method static self PENDING()
 * @method static self PROCESSING()
 * @method static self COMPLETED()
 * @method static self CANCELLED()
 */
class OrderStatusEnum extends Enum
{
    public static function values(): array
    {
        return [
            'PENDING'     => 'pending',
            'PROCESSING'  => 'processing',
            'COMPLETED'   => 'completed',
            'CANCELLED'   => 'cancelled',
        ];
    }

    public function getLabel(): string
    {
        return match ($this->value) {
            'pending'     => 'În așteptare',
            'processing'  => 'În procesare',
            'completed'   => 'Finalizată',
            'cancelled'   => 'Anulată',
            default       => 'Necunoscută',
        };
    }

    public function getBadgeColor(): string
    {
        return match ($this->value) {
            'pending'     => 'warning',
            'processing'  => 'info',
            'completed'   => 'success',
            'cancelled'   => 'danger',
            default       => 'secondary',
        };
    }
}
