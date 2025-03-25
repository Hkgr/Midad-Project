<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class cart extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table ='carts';
    
    protected $fillable = [
        'name',
        'user_id',
        'total_price',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
