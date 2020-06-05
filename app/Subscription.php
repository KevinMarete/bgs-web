<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_subscription';

    protected $fillable = ['start_date', 'end_date', 'organization_id', 'package_id'];

    public static $rules = [
        "start_date" => "required|date",
        "end_date" => "required|date",
        "organization_id" => "required|numeric",
        "package_id" => "required|numeric"
    ];

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function package()
    {
        return $this->belongsTo('App\Package');
    }
}
