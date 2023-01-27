<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationSupplierCategory extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_organization_supplier_category';

    protected $fillable = ['organization_id', 'supplier_category_id'];

    public static $rules = [
        "organization_id" => "required|numeric",
        "supplier_category_id" => "required|numeric"
    ];

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function supplier_category()
    {
        return $this->belongsTo('App\SupplierCategory');
    }

}
