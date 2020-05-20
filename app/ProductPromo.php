<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPromo extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_product_promo';

    protected $fillable = ['coupon_code', 'product_now_id', 'offer_id'];

    public static $rules = [
        "coupon_code" => "required",
        "product_now_id" => "required|numeric",
        "offer_id" => "required|numeric"
	];

    public function product_now()
    {
        return $this->belongsTo('App\ProductNow');
    }
    
    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }
}