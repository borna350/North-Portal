<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeOfConduct extends Model {
    use  SoftDeletes, HasEmployee;

    protected $guarded = [];

    protected $table = "codeofconducts";
}
