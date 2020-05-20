<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentNow extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_now';

    protected $fillable = ['payment_id', 'product_now_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "product_now_id" => "required|numeric"
	];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function product_now()
    {
        return $this->belongsTo('App\ProductNow');
    }
}