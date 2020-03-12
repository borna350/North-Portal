<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model {
    use  SoftDeletes, HasEmployee;
    public static $agreementFileLocation = 'agreement-file-path';

    public $table = "agreements";

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function amendments () {
        // don't need to add "where status = 'D' because it's irrelavent.  If the status changes to D, so will the parent, so no need to look for it
        return $this->hasMany(Agreement::class, 'parent_id')->orderBy('created_at');
    }
}
