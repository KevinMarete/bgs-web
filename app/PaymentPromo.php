<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentPromo extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_promo';

    protected $fillable = ['payment_id', 'product_promo_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "product_promo_id" => "required|numeric"
	];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function product_promo()
    {
        return $this->belongsTo('App\ProductPromo');
    }
}