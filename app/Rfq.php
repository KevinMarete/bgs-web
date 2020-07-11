<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rfq extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_rfq';

    protected $fillable = ['status', 'terms', 'organization_id'];

    public static $rules = [
        "status" => "required",
        "organization_id" => "required|numeric"
    ];

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function rfq_items()
    {
        return $this->hasMany('App\RfqItem');
    }

    public function rfq_logs()
    {
        return $this->hasMany('App\RfqLog');
    }

    public function rfq_reject()
    {
        return $this->hasOne('App\RfqReject');
    }

    public function rfq_rejects()
    {
        return $this->hasMany('App\RfqReject');
    }
}
