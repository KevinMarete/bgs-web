<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockBalance extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_stock_balance';

    protected $fillable = ['batch_number', 'expiry_date', 'quantity', 'product_id', 'organization_id'];

    public static $rules = [
        "batch_number" => "required",
        "expiry_date" => "required|date",
        "quantity" => "required|numeric",
        "balance" => "required|numeric",
        "product_id" => "required|numeric",
        "organization_id" => "required|numeric"
	];

	public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
    
}