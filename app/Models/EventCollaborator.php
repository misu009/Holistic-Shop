<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCollaborator extends Model
{
    use HasFactory;
    protected $table = 'event_collaborator';
    protected $fillable = [
        'event_id',
        'collaborator_id',
        'is_primary'
    ];
}
