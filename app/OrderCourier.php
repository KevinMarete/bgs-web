<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCourier extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_order_courier';

    protected $fillable = ['order_id', 'courier_id'];

    public static $rules = [
        "order_id" => "required|numeric",
        "courier_id" => "required|numeric"
	];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function courier()
    {
        return $this->belongsTo('App\Courier');
    }
}