<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use CreateTargetsRecurringCheckboxTable;
use CreateUpdatesRecurringCheckboxTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpdateRecurringCheckbox extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = CreateUpdatesRecurringCheckboxTable::TABLE;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target_id',
        'achieved_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'achieved_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'target_id' => 'integer',
    ];

    // Relationships
    /**
     * Many-to-One.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target()
    {
        return $this->belongsTo(TargetRecurringCheckbox::class, CreateTargetsRecurringCheckboxTable::PK);
    }
}
