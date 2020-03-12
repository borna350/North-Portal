<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo};

class ClassroomArchive extends Model {
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function user () {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function classroomChapter () {
        return $this->belongsTo(ClassroomChapter::class);
    }
}
