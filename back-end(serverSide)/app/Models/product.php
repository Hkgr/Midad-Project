<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'stock', 'category_id', 'description', 'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

