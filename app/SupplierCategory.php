<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierCategory extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_supplier_category';

    protected $fillable = ['name'];

    public static $rules = [
        "name" => "required|unique:tbl_supplier_category"
    ];

}
