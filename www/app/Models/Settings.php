<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use Illuminate\Database\Eloquent\Model;
use StartMeUp\User;

class Settings extends Model
{
    const COLOUR_PALETTE_A = 'A';
    const COLOUR_PALETTE_B = 'B';
    const COLOUR_PALETTE_C = 'C';
    const COLOUR_PALETTE_D = 'D';
    const COLOUR_PALETTES = [
        self::COLOUR_PALETTE_A,
        self::COLOUR_PALETTE_B,
        self::COLOUR_PALETTE_C,
        self::COLOUR_PALETTE_D,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'share_address' => 'boolean',
        'share_birthday' => 'boolean',
        'share_email' => 'boolean',
        'share_gender' => 'boolean',
        'share_interests' => 'boolean',
        'share_locality' => 'boolean',
        'share_location' => 'boolean',
        'share_mobile' => 'boolean',
        'share_picture' => 'boolean',
        'share_progress' => 'boolean',
        'show_notifications' => 'boolean',
        'want_to_collaborate' => 'boolean',
    ];

    // Relationships
    // =============
    /**
     * One-to-One (inverse).
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-one
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
