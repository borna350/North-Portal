<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mileage extends Model {
    use HasEmployee, SoftDeletes, SearchTrait;

    public $table = "mileages";
    protected $guarded = [];
    protected $fillable = ['emp_id', 'company', 'date', 'vehicle', 'kilometers', 'reasonmileage'];
    protected $dates = ['date'];
}
