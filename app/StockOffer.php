<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOffer extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_stock_offer';

    protected $fillable = ['stock_id', 'offer_id'];

    public static $rules = [
        "stock_id" => "required|numeric",
        "offer_id" => "required|numeric"
	];

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }

    public function offer()
    {
        return $this->hasMany('App\Offer');
    }

}