<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo};
use stdClass;

class ClassroomAssignment extends Model {
    protected $guarded = ['id'];
    protected $dates = ['completion_date'];

    /**
     * @return BelongsTo
     */
    public function classroomCourse () {
        return $this->belongsTo(ClassroomCourse::class);
    }

    /**
     * @return BelongsTo
     */
    public function user () {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Unknown']);
    }

    /**
     * @param string $key
     * @param string $val
     */
    public function updateProgress ($key, $val) {
        $status = new stdClass();
        if ($this->course_status) {
            $status = json_decode($this->course_status);
        }

        $status->$key = $val;
        $this->course_status = json_encode($status);
        $this->save();
    }
}
