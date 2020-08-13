<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
  use SoftDeletes;

  protected $table = 'tbl_faq';

  protected $fillable = ['question', 'answer'];

  public static $rules = [
    "question" => "required",
    "answer" => "required",
  ];
}
