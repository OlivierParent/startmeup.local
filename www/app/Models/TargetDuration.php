<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use CreateTargetsDurationTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetDuration extends Model
{
    use SoftDeletes;

    const TIME_INCREMENT_DAY = 'DAY';
    const TIME_INCREMENT_HOUR = 'HOUR';
    const TIME_INCREMENT_QUARTER_HOUR = 'QUARTER_HOUR';
    const TIME_INCREMENTS = [
        self::TIME_INCREMENT_QUARTER_HOUR,
        self::TIME_INCREMENT_HOUR,
        self::TIME_INCREMENT_DAY,
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = CreateTargetsDurationTable::TABLE;

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
        'time_estimated',
        'time_increment',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'time_estimated' => 'integer',
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
        return $this->hasMany(UpdateDuration::class, CreateTargetsDurationTable::FK);
    }
}
