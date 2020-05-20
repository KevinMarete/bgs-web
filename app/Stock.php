<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{	
	use SoftDeletes;

    protected $table = 'tbl_stock';

    protected $fillable = ['transaction_date', 'batch_number', 'expiry_date', 'quantity', 'balance', 'product_id', 'stock_type_id', 'organization_id', 'user_id'];

    public static $rules = [
        "transaction_date" => "required|date",
        "batch_number" => "required",
        "expiry_date" => "required|date",
        "quantity" => "required|numeric",
        "balance" => "required|numeric",
        "product_id" => "required|numeric",
        "stock_type_id" => "required|numeric",
        "organization_id" => "required|numeric",
        "user_id" => "required|numeric"
	];

	public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function stock_type()
    {
        return $this->belongsTo('App\StockType');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}