<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['ip', 'session_id', 'visited_at'];

    public static function visitsLast30DaysUntilNoon()
    {
        $endDate = now();
        $startDate = $endDate->copy()->subDays(29)->startOfDay();
        $startUtc = $startDate->copy()->utc();
        $endUtc = $endDate->copy()->utc();
        return self::whereBetween('visited_at', [$startUtc, $endUtc])->count();
    }
}
