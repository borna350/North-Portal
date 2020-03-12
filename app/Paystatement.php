<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Paystatement extends Model {
    use HasEmployee;
    use  SoftDeletes;
    use  SearchTrait;
    public static $payStatementFileLocation = 'pay-statement-file';

    public $timestamps = false;

    protected $primaryKey = 'emp_id';

    protected $fillable = ['emp_id', 'pdfname', 'description', 'date', 'created_at'];

}
