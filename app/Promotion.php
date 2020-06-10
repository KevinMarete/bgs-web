<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_promotion';

    protected $fillable = ['type', 'status', 'display_date', 'display_url', 'product_now_id', 'organization_id'];

    public static $rules = [
        "type" => "required",
        "status" => "required",
        "display_date" => "required",
        "display_url" => "required",
        "product_now_id" => "required|numeric",
        "organization_id" => "required|numeric"
    ];

    public function product_now()
    {
        return $this->belongsTo('App\ProductNow');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}
