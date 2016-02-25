<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use CreateTargetsRecurringCheckboxTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetRecurringCheckbox extends Model
{
    use SoftDeletes;

    const REPEAT_DAILY = 'DAILY';
    const REPEAT_FORTNIGHTLY = 'FORTNIGHTLY';
    const REPEAT_MONTHLY = 'MONTHLY';
    const REPEAT_WEEKLY = 'WEEKLY';
    const REPEATS = [
        self::REPEAT_DAILY,
        self::REPEAT_WEEKLY,
        self::REPEAT_FORTNIGHTLY,
        self::REPEAT_MONTHLY,
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = CreateTargetsRecurringCheckboxTable::TABLE;

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
        'repeat_deadline',
        'repeat_until_date',
        'repeat_until_time',
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
     * One-to-Many.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-many
     *
     * @return mixed
     */
    public function updates()
    {
        return $this->hasMany(UpdateRecurringCheckbox::class, CreateTargetsRecurringCheckboxTable::FK);
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
