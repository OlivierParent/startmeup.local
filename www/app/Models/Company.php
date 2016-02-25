<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Models;

use Illuminate\Database\Eloquent\Model;
use StartMeUp\User;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
    ];

    // Relationships
    // =============
    /**
     * One-to-One (inverse).
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-one
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * One-to-OneOrMany.
     *
     * @link http://laravel.com/docs/5.1/eloquent-relationships#one-to-one
     *
     * @return mixed
     */
    public function users()
    {
        return $this->hasOneOrMany(User::class);
    }
}
