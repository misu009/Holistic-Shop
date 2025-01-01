<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsMedia extends Model
{
    use HasFactory;
    protected $table = 'events_media';

    protected $fillable = [
        'events_id',
        'path',
        'order',
    ];

    public function events()
    {
        return $this->belongsTo(Events::class, 'events_id');
    }
}
