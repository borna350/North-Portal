<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, SoftDeletes};
class Expenses extends Authenticatable {
    use Notifiable, HasRoles, HasEmployee, SearchTrait;
    use  SoftDeletes;
    public static $expenseReceiptLocation = 'expense-receipt';

    public $table = "expenses";
    // protected $fillable = ['company', 'date', 'vehicle', 'kilometers', 'reasonmileage'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = [];
    protected $guarded  = [];
    protected $dates = ['date'];

    /* public function setPasswordAttribute($password)
     {
         $this->attributes['password'] = bcrypt($password);
     }*/

    /**
     * Get the company that owns the expense
     *
     * @return BelongsTo
     */
    public function companyRel ()
    {
        return $this->belongsTo(Company::class, 'company', 'id');
    }

    /**
     * Get the category that owns the expense
     *
     * @return BelongsTo
     */
    public function categoryRel ()
    {
        return $this->belongsTo(Categorys::class, 'category', 'id');
    }

    /**
     * Get the purchase that owns the expense
     *
     * @return BelongsTo
     */
    public function purchaseRel ()
    {
        return $this->belongsTo(Purchases::class, 'purchase', 'id');
    }

    /**
     * Get the project that owns the expense
     *
     * @return BelongsTo
     */
    public function projectRel ()
    {
        return $this->belongsTo(Project::class, 'project', 'id');
    }
}
