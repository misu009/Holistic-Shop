<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'long_description',
        'short_description',
        'email',
        'phone_number',
        'picture',
    ];

    public function events()
    {
        return $this->belongsToMany(Events::class);
    }
}