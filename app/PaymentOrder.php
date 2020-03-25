<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOrder extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_order';

    protected $fillable = ['payment_id', 'order_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "order_id" => "required|numeric"
	];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}