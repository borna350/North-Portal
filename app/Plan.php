<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use SearchTrait;
    public static $planFileLocation = 'plan-file';
}
