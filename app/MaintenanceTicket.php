<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class MaintenanceTicket extends Authenticatable {
    use SoftDeletes, Notifiable, HasRoles, HasEmployee, SearchTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'website', 'description', 'priority', 'category', 'user', '_token', 'emp_id'];

    /* public function setPasswordAttribute($password)
     {
         $this->attributes['password'] = bcrypt($password);
     }*/

    /**
     * Users records associated with ticket
     *
     * @return BelongsToMany
     */
    public function users () {
        return $this->belongsToMany(User::class);
    }
}
