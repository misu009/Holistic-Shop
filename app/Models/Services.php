<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
        'email',
        'picture',
        'phone_number',
        'price',
        'disabled'
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
}