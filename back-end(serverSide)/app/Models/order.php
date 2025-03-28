<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class order extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table ='orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];

      
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
