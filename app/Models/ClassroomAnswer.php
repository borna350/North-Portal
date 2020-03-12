<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, SoftDeletes};

class ClassroomAnswer extends Model {

    protected $guarded = ['id'];
    use SoftDeletes;

    /**
     * @return BelongsTo
     */
    public function user () {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Unknown']);
    }

    /**
     * @return BelongsTo
     */
    public function classroomQuestion () {
        return $this->belongsTo(ClassroomQuestion::class);
    }
}
