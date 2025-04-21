<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';

    protected $fillable = [
        'name',
        'description',
        'email',
        'phone_number',
        'starts_at',
        'ends_at',
        'price',
        'disabled'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function collaborators()
    {
        return $this->belongsToMany(Collaborator::class)
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    public function primaryCollaborators()
    {
        return $this->collaborators()->wherePivot('is_primary', true);
    }

    public function nonPrimaryCollaborators()
    {
        return $this->collaborators()->wherePivot('is_primary', false);
    }

    public function media()
    {
        return $this->hasMany(EventsMedia::class, 'events_id')->orderBy('order', 'asc');
    }
}
