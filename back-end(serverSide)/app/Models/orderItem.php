<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class orderItem extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table ='order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'total_price',
        'quantity'      
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
