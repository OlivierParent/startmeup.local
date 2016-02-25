<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use CreateTargetsCheckboxTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetCheckbox extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = CreateTargetsCheckboxTable::TABLE;

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
        'deadline_date',
        'deadline_time',
        'deadline_reminder',
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
    ];

    // Relationships
    // =============
    /**
     * Polymorphic One-to-One.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#polymorphic-relations
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function goal()
    {
        return $this->morphOne(Goal::class, 'targetable');
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function getDeadlineReminderAttribute($value)
    {
        return (bool) $value;
    }
}
