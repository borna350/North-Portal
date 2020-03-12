<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, Relations\HasOne, SoftDeletes};
use Illuminate\Support\Facades\Auth;

class ClassroomQuestion extends Model {

    use SoftDeletes;
    public static $questionTypes = [
        'radio'    => 'Multiple-Choice - 1 Answer',
        'checkbox' => 'Multiple-Choice - 1 or more answers',
        'audio'    => 'Audio',
        'textbox'  => 'Textbox / Notes'
    ];

    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function classroomChapter () {
        return $this->belongsTo(ClassroomChapter::class);
    }

    /**
     * @param null|int $userID
     *
     * @return HasOne
     */
    public function classroomAnswers ($userID = null) {
        if (is_null($userID)) {
            $userID = Auth::user()->id;
        }

        return $this->hasOne(ClassroomAnswer::class)->where('user_id', $userID);
    }

    /**
     * @return HasOne
     */
    public function answers () {
        return $this->hasOne(ClassroomAnswer::class);
    }

    /**
     * @return BelongsTo
     */
    public function classroomSection () {
        return $this->belongsTo(ClassroomSection::class);
    }

    /**
     * @return mixed|string
     */
    public function getQuestionDetailsAttribute () {
        return $this->questions ? json_decode($this->questions) : '';
    }

    /**
     * @param string $response
     *
     * @return bool
     */
    public function checkCheckboxAnswer ($response) {
        if (!isset($this->classroomAnswers->answer)) {
            return false;
        }

        $answer = json_decode($this->classroomAnswers->answer);

        return is_array($answer) && in_array($response, $answer);
    }
}
