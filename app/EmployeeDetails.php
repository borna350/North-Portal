<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDetails extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    public static $profileLocation = 'profile';
    protected $fillable = [
        'firstname',
        'lastname',
        'dob',
        'personalemail',
        'phone_no',
        'address',
        'workemail',
        'profile_pic',
        'marital_status',
        'no_ofchildren',
        'family_inarea',
        'familycircumstance',
        'prsnl_belief',
        'known_medical_conditions',
        'allergies',
        'dietary_restrictions',
        'known_health_concerns',
        'aversion_phyactivity',
        'emergency_contact_name',
        'reltn_emergency_contact',
        'emergency_contact_phone',
        'emergency_contact_email',
        'company_id'
    ];

    /**
     * @return HasOne
     */
    public function user ()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }

    /**
     * Get name attributes
     * @return string
     */
    public function getNameAttribute ()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * Get the agreement that owns the employee details
     * @return HasOne
     */
    public function activeAgreement ()
    {
        return $this->hasOne(Agreement::class, 'emp_id')->where('status', 'A')->whereNull('parent_id');
    }

    /**
     * Get the personal development plan that owns the employee details
     * @return HasMany
     */
    public function personalPlan ()
    {
        return $this->hasMany('App\PersonalDevelopmentPlan', 'emp_id', 'id');
    }

    /**
     * Get the codeOfConduct that owns the employee details
     * @return HasOne
     */
    public function activeCodeofconduct ()
    {
        return $this->hasOne(CodeOfConduct::class, 'emp_id')->where('status', 'A');
    }

    /**
     * Get the company that owns the employee details
     * @return BelongsTo
     */
    public function company ()
    {
        return $this->belongsTo(Company::class);
    }
}
