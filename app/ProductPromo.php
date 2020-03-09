<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPromo extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_product_promo';

    protected $fillable = ['product_now_id', 'offer_id'];

    public static $rules = [
        "product_now_id" => "required|numeric",
        "promo_id" => "required|numeric"
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