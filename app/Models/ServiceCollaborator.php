<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCollaborator extends Model
{
    use HasFactory;
    protected $table = 'collaborator_services';
    protected $fillable = [
        'services_id',
        'collaborator_id',
        'is_primary'
    ];
}