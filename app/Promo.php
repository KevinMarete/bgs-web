<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_promo';

    protected $fillable = ['coupon_code', 'offer_id'];

    public static $rules = [
        "coupon_code" => "required|unique:tbl_promo",
        "offer_id" => "required|numeric",
    ];
    
    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

}