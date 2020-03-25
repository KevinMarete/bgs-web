<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_order_item';

    protected $fillable = ['quantity', 'unit_price', 'shipping_price', 'sub_total', 'shipping_total', 'discount', 'total_cost', 'product_now_id', 'organization_id', 'order_id'];

    public static $rules = [
        "quantity" => "required|numeric",
        "unit_price" => "required|numeric",
        "shipping_price" => "required|numeric",
        "sub_total" => "required|numeric",
        "shipping_total" => "required|numeric",
        "discount" => "required|numeric",
        "total_cost" => "required|numeric",
        "product_now_id" => "required|numeric",
        "organization_id" => "required|numeric",
        "order_id" => "required|numeric"
	];

    public function product_now()
    {
        return $this->belongsTo('App\ProductNow');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}