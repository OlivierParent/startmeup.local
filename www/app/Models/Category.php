<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use StartMeUp\User;

class Category extends Model
{
    use SoftDeletes;

    const DEFAULT_CATEGORIES = [
        [
            'name' => 'Startup Formalities',
            'description' => 'Goals related to the formal requirements for starting a business.',
        ],
        [
            'name' => 'Business Plan',
            'description' => 'Goals that are part of your business plan.',
        ],
        [
            'name' => 'Healthy Living',
            'description' => 'Goals to keep you mentally and physically fit.',
        ],
        [
            'name' => 'Social Life',
            'description' => 'Goals to keep your social life alive and kicking.',
        ],
        [
            'name' => 'Zen Calming Activities',
            'description' => 'Activities at regular intervals to calm yourself.',
        ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    /**
     * The attributes included in the model's JSON form.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'description',
        'order',
        'goals',
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

    /**
     * One-to-Many.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }
}
