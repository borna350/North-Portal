<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Journal extends Model
{
    use SoftDeletes, SearchTrait;
    public $table = "journals";
    protected $fillable = ['date', 'title', 'details'];
    protected $dates = ['date'];
}
