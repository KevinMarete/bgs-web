<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_deal';

    protected $fillable = ['minimum_order_quantity', 'offer_id'];

    public static $rules = [
        "minimum_order_quantity" => "required",
        "offer_id" => "required|numeric",
    ];
    
    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

}