<?php

namespace App;

use App\Models\{ClassroomAssignment,ClassroomCourse};
use Illuminate\Database\Eloquent\Relations\{BelongsToMany,HasMany,HasManyThrough,HasOne};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use Notifiable, HasRoles, SoftDeletes;

    public static $profileLocation = 'profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_admin',
        'is_ticket_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get Employee Details
     *
     * @return HasOne
     */
    public function employee_details() {
        return $this->hasOne(EmployeeDetails::class, 'id', 'id');
    }

    /**
     * Get Mileage
     * @return HasMany
     */
    public function mileage() {
        return $this->hasMany(Mileage::class,'emp_id');
    }
    /* public function setPasswordAttribute($password)
     {
         $this->attributes['password'] = bcrypt($password);
     }*/

    /**
     * Ticket records associated with users
     *
     * @return BelongsToMany
     */
    public function tickets() {
        return $this->belongsToMany(MaintenanceTicket::class);
    }

    /**
     * @return HasManyThrough
     */
    public function courses () {
        return $this->hasManyThrough(ClassroomCourse::class, ClassroomAssignment::class, 'user_id', 'id', 'id', 'classroom_course_id');
    }
}
