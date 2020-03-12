<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use SearchTrait;
    public static $missionFileLocation = 'mission-file';
}
