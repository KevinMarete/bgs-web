<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RfqItem extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_rfq_item';

    protected $fillable = ['quantity', 'unit_price', 'shipping_price', 'sub_total', 'shipping_total', 'total_cost', 'out_of_stock', 'product_now_id', 'organization_id', 'rfq_id'];

    public static $rules = [
        "quantity" => "required|numeric",
        "unit_price" => "required|numeric",
        "shipping_price" => "required|numeric",
        "sub_total" => "required|numeric",
        "shipping_total" => "required|numeric",
        "total_cost" => "required|numeric",
        "product_now_id" => "required|numeric",
        "organization_id" => "required|numeric",
        "rfq_id" => "required|numeric"
    ];

    public function product_now()
    {
        return $this->belongsTo('App\ProductNow');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function rfq()
    {
        return $this->belongsTo('App\Rfq');
    }
}
