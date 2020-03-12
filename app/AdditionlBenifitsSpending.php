<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class AdditionlBenifitsSpending extends Model
{
    use  SoftDeletes, SearchTrait;
    public $table = "additionl_benifits_spendings";
    protected $fillable = ['date', 'description', 'total', 'pay_status', 'status'];
    protected $dates = ['date'];
}
