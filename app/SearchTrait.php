<?php

namespace App;

use Illuminate\Database\Query\Builder;

Trait SearchTrait {

    /**
     * Do all the logic for searching dates
     *
     * @param Builder $q
     * @param string  $field
     */
    public function scopeDateSearch ($q, $field = 'created_at') {
        $from = request()->input('from');
        $to = request()->input('to');

        if ($from && $to) {
            $q->whereBetween($field, [$from, $to]);
        }
        elseif ($from) {
            $q->where($field, '>=', $from);
        }
        elseif ($to) {
            $q->where($field, '<=', $to);
        }
    }

    /**
     * Only show values related to the employee
     *
     * @param Builder $q
     */
    public function scopeIsEmployee ($q) {
        if (!auth()->user()->is_admin) {
            $q->where('emp_id',auth()->user()->id);
        }
    }
}
