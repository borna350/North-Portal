<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, Relations\HasMany, SoftDeletes};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClassroomChapter extends Model {

    use SoftDeletes;

    public static $chapterPathLocation = 'chapter-file-path';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function classroomCourse () {
        return $this->belongsTo(ClassroomCourse::class);
    }

    /**
     * @return HasMany
     */
    public function questions () {
        return $this->hasMany(ClassroomQuestion::class);
    }

    /**
     * @return HasMany
     */
    public function questionsInOrder () {
        return $this->hasMany(ClassroomQuestion::class)->orderBy('orderval');
    }

    /**
     * @return HasMany
     */
    public function classroomSections () {
        return $this->hasMany(ClassroomSection::class)->orderBy('orderval');
    }

    /**
     * @param null|int $userID
     *
     * @return HasMany
     */
    public function userClassroomAnswers ($userID = null) {
        if (!is_null($userID)) {
            $userID = Auth::user()->id;
        }

        return $this->classroomAnswers()->where('user_id', $userID);
    }

    /**
     * @return HasMany
     */
    public function classroomAnswers () {
        return $this->hasMany(ClassroomAnswer::class);
    }

    /**
     * @return mixed
     */
    public function nextQuestion () {
        // find last answered question (answer doesn't have enough information)
        $lastQuestion = $this->lastQuestionAnswered()->classroomQuestion;

        // check to see if there is a next question
        $nextQuestion = ClassroomQuestion::select('id')->where('classroom_section_id', $lastQuestion->classroom_section_id)->where('orderval', '>', $lastQuestion->orderval)
            ->orderBy('orderval')->first();

        // if not, move to the next section (this should always find something, as this only gets called when a section isn't complete)
        if (!$nextQuestion) {
            $lastSection = $lastQuestion->classroomSection;
            $nextSection = ClassroomSection::where('classroom_chapter_id', $lastSection->classroom_chapter_id)->where('orderval', '>', $lastSection->orderval)->orderBy('orderval')
                ->first();
            $nextQuestion = $nextSection->classroomQuestionsOrder()->select('id')->first();
        }

        return $nextQuestion;
    }

    /**
     * @return mixed
     */
    public function lastQuestionAnswered () {
        return $this->hasManyThrough(ClassroomAnswer::class, ClassroomQuestion::class, 'classroom_chapter_id', 'classroom_question_id')->orderByDesc('classroom_answers.updated_at')
            ->where('user_id', Auth::User()->id)->first();
    }

    /**
     * @return mixed
     */
    public function getS3URLAttribute () {
        return Storage::disk('s3')->url(ClassroomCourse::$courseLocation . '/' . $this->getS3NameAttribute());
    }

    /**
     * @return string
     */
    public function getS3NameAttribute () {
        return str_pad($this->classroom_course_id, 4, '0', STR_PAD_LEFT) . str_pad($this->id, 4, '0', STR_PAD_LEFT) . '.pdf';
    }
}
