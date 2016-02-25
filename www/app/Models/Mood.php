<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use StartMeUp\User;

class Mood extends Model
{
    const FEELING_ENERGIZED = 'ENERGIZED';
    const FEELING_EXHAUSTED = 'EXHAUSTED';
    const FEELING_GOOD = 'GOOD';
    const FEELING_OK = 'OK';
    const FEELING_TIRED = 'TIRED';
    const FEELINGS = [
        self::FEELING_ENERGIZED,
        self::FEELING_GOOD,
        self::FEELING_OK,
        self::FEELING_TIRED,
        self::FEELING_EXHAUSTED,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feeling',
        'user_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
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
     * Many-to-One.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Query Scopes
    // ============
    /**
     * Scope a query to count feeling.
     *
     * @param $query
     * @param $userId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatistics($query, $userId)
    {
        // SELECT feeling, COUNT(feeling) AS count FROM moods WHERE user_id = :userId GROUP BY feeling

        return $query
            ->select('feeling', DB::raw('COUNT(feeling) AS count'))
            ->where('user_id', $userId)
            ->groupBy('feeling');
    }
}
