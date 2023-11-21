<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function Models()
    {
        return $this->BelongsTo(Models::class,'models_id');
    }

    public function Cars(){
        return $this->BelongsTo(Cars::class,'cars_id');

    }


    public function users()
    {
        return $this->BelongsTo(User::class,'user_id');
    }
}
