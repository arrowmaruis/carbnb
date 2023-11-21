<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_infos extends Model
{
    use HasFactory;
    protected $fillable = [
        'user__Id',
        'birthday',
        'location',
        'type_card',
        'card_imgs',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
