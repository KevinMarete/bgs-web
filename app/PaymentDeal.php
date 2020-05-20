<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentDeal extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_payment_deal';

    protected $fillable = ['payment_id', 'product_deal_id'];

    public static $rules = [
        "payment_id" => "required|numeric",
        "product_deal_id" => "required|numeric"
	];

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function product_deal()
    {
        return $this->belongsTo('App\ProductDeal');
    }
}