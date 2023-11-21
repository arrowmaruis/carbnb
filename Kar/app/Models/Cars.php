<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cars extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected $casts = [
        'equipements' => 'array',
        'photos' => 'array',
    ];



    public function Models()
    {
        return $this->BelongsTo(models::class);
    }

    public function scopeCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function equipements()
    {
        return $this->belongsToMany(Equipements::class); // Utilisez "belongsToMany" pour une relation de plusieurs-à-plusieurs
    }

    // public function users()
    // {
    //     return $this->BelongsTo(User::class);
    // }

    // Car.php

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
