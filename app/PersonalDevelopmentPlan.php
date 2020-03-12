<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, Relations\HasMany, SoftDeletes};

class PersonalDevelopmentPlan extends Model
{
    use SoftDeletes, SearchTrait;
    public $table = "personal_development_plans";
    protected $fillable = ['emp_id', 'title', 'description', 'start_date', 'end_date', 'comment'];
    protected $dates = ['start_date'];

    /**
     * Get the personal development plan that owns the employee details
     * @return BelongsTo
     */
    public function employee (){
        return $this->belongsTo('App\EmployeeDetails', 'emp_id', 'id');
    }
}
