<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_order';

    protected $fillable = ['status', 'product_total', 'shipping_total', 'organization_id'];

    public static $rules = [
        "status" => "required",
        "product_total" => "required|numeric",
        "shipping_total" => "required|numeric",
        "organization_id" => "required|numeric"
	];

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function order_logs()
    {
        return $this->hasMany('App\OrderLog');
    }
}