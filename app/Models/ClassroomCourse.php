<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\HasMany, SoftDeletes};
use Illuminate\Support\Facades\{Auth, Storage};

class ClassroomCourse extends Model {

    public static $courseLocation = 'classroom-courses';
    use SoftDeletes;
    public static $s3PathLocation = 's3-file-path';
    public static $imagePathLocation = 'image-file_path';
    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function chapters () {
        return $this->hasMany(ClassroomChapter::class)->orderBy('orderval');
    }

    /**
     * @param null|int $userID
     *
     * @return Model|HasMany|object|null
     */
    public function userArchives ($userID = null) {
        if (is_null($userID)) {
            $userID = Auth::user()->id;
        }

        return $this->archives()->where('user_id', $userID);
    }

    /**
     * @return HasMany
     */
    public function archives () {
        return $this->hasMany(ClassroomArchive::class);
    }

    /**
     * @param null|int $chapter
     * @param null|int $userID
     *
     * @return string
     */
    public function getStatus ($chapter = null, $userID = null) {
        static $status; // reduces the number of queries on the chapter page

        if (!isset($status)) {
            $status = $this->userAssignments($userID)->course_status;
        }
        if (!$status) {
            $status = '';

            return 'unavailable';
        }

        $array = get_object_vars(json_decode($status));

        return $array[ 'chapter-' . $chapter ] ?? 'unavailable';
    }

    /**
     * @param null|int $userID
     *
     * @return HasMany
     */
    public function userAssignments ($userID = null) {
        if (is_null($userID)) {
            $userID = Auth::user()->id;
        }

        return $this->assignments()->where('user_id', $userID)->first();
    }

    /**
     * @return HasMany
     */
    public function assignments () {
        return $this->hasMany(ClassroomAssignment::class);
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
        return str_pad($this->id, 4, '0', STR_PAD_LEFT) . '.pdf';
    }
}
