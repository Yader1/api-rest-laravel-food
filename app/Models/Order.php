<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model{
    use DefaultDatetimeFormat;
    //table name
    protected $table = 'orders';
    protected $casts = [
        'order_amount' => 'float',
        'total_tax_amount' => 'float',
        'delivery_address_id' => 'integer',
        'delivery_charge' => 'float',
        'user_id' => 'integer',
        'scheduled' => 'integer',
        'details_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function setDeliveryChargeAttribute($value){
        $this->attributes['delivery_charge'] = round($value, 3);
    }

    public function details(){
        return $this->hasMany(OrderDetail::class);
    }

    public function scopeNotpos($query){
        return $query->where('order_type', '<>', 'pos');
    }

    public function user(){
        return $this->belongsTo(user::class, 'user_id');
    }

    public function detailsOrdes(){
        return $this->hasOne(OrderDetail::class, 'id', 'order_detail_id');
    }

    //public function FoodType(){
       // return $this->hasOne(FoodType::class, 'id', 'type_id');
    //}
}