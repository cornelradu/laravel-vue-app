<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['timestamp', 'user_id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
?>