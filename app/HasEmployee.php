<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

Trait HasEmployee {

    /**
     * Get the employee details that owns the has employee.
     * @return BelongsTo
     */
    public function employee () {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id')->withDefault(['firstname' => 'Deleted', 'lastname' => 'User']);
    }
}
