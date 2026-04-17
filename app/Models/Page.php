<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_system',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     * * This tells Laravel to automatically search by 'slug' instead of 'id'
     * when using Route Model Binding (e.g., Route::get('/p/{page}'))
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
