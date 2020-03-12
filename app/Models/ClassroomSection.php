<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, Relations\HasMany, SoftDeletes};

class ClassroomSection extends Model {
    use SoftDeletes;
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function classroomChapter () {
        return $this->belongsTo(ClassroomChapter::class);
    }

    /**
     * @return HasMany
     */
    public function classroomQuestions () {
        return $this->hasMany(ClassroomQuestion::class);
    }

    /**
     * @return HasMany
     */
    public function classroomQuestionsOrder () {
        return $this->hasMany(ClassroomQuestion::class)->orderBy('orderval');
    }
}
