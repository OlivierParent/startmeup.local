<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use StartMeUp\User;

class Goal extends Model
{
    const DEFAULT_GOALS = [
        'Startup Formalities' => [
            [
                'name' => 'Company registration number',
                'notes' => '',
                'target_class' => 'TargetCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Health insurance',
                'notes' => '',
                'target_class' => 'TargetCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Social security',
                'notes' => '',
                'target_class' => 'TargetCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'VAT registration',
                'notes' => '',
                'target_class' => 'TargetCheckbox',
                'in_progress' => false,
            ],
        ],
        'Business Plan' => [
            [
                'name' => 'Clients',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Commercial Plan',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Financial Plan',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Market Research',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Suppliers',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
        ],
        'Healthy Living' => [
            [
                'name' => 'Healthy food',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Physical activity',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Sleep',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
        ],
        'Social Life' => [
            [
                'name' => 'Family gathering',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Friends gathering',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
            [
                'name' => 'Peer gathering',
                'notes' => '',
                'target_class' => 'TargetRecurringCheckbox',
                'in_progress' => false,
            ],
        ],
        'Zen Calming Activities' => [
            [
                'name' => 'Meditation',
                'notes' => '',
                'target_class' => 'TargetDuration',
                'in_progress' => false,
            ],
            [
                'name' => 'Tai Chi',
                'notes' => '',
                'target_class' => 'TargetDuration',
                'in_progress' => false,
            ],
            [
                'name' => 'Yoga',
                'notes' => '',
                'target_class' => 'TargetDuration',
                'in_progress' => false,
            ],
            [
                'name' => 'Walking',
                'notes' => '',
                'target_class' => 'TargetDuration',
                'in_progress' => false,
            ],
        ],
    ];
    const PRIORITY_HIGH = 'HIGH';
    const PRIORITY_HIGHEST = 'HIGHEST';
    const PRIORITY_LOW = 'LOW';
    const PRIORITY_LOWEST = 'LOWEST';
    const PRIORITY_NORMAL = 'NORMAL';
    const PRIORITIES = [
        self::PRIORITY_LOWEST,
        self::PRIORITY_LOW,
        self::PRIORITY_NORMAL,
        self::PRIORITY_HIGH,
        self::PRIORITY_HIGHEST,
    ];

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'notes',
        'in_progress',
    ];

    /**
     * The attributes included in the model's JSON form.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'category_id',
        'name',
        'notes',
        'in_progress',
        'target',
        'target_class',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'target_class',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
//        'deadline_at',
        'achieved_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'in_progress' => 'boolean',
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
     * Many-to-One.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Polymorphic One-to-One.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#polymorphic-relations
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function target()
    {
        return $this->morphTo();
    }

    /**
     * Custom attribute that contains the class name of the Target.
     *
     * @return string
     */
    public function getTargetClassAttribute()
    {
        $targetClass = new ReflectionClass($this->target_type);

        return $targetClass->getShortName();
    }

    // Query Scopes
    // ============
    /**
     * Scope a query to only include Goals that are in progress.
     *
     * @param $query
     * @param $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProgress($query, $value)
    {
        return $query->where('in_progress', $value);
    }
}
