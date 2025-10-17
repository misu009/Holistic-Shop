<?php

namespace App\Models;

use App\Models\Casts\Order\OrderStatusEnumCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'birth_date',
        'country',
        'city',
        'address',
        'postal_code',
        'notes',
        'total',
        'status',
        'client_type',
        'company_name',
        'company_cui',
        'company_reg',
        'company_address',
    ];

    protected $casts = [
        'status' => OrderStatusEnumCast::class,
        'birth_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}