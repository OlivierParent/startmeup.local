<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    const GENDER_FEMALE = 'FEMALE';
    const GENDER_MALE = 'MALE';
    const GENDER_OTHER = 'OTHER';
    const GENDERS = [
        self::GENDER_FEMALE,
        self::GENDER_MALE,
        self::GENDER_OTHER,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'given_name',
        'family_name',
        'gender',
        'biography',
        'birthday',
        'mobile',
        'picture',
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
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'birthday',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * One-to-Many.
     *
     * @link http://laravel.com/docs/5.0/eloquent#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('StartMeUp\Models\Category');
    }

    /**
     * Many-to-One.
     *
     * @link http://laravel.com/docs/5.0/eloquent#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('StartMeUp\Models\Company');
    }

    /**
     * One-to-Many.
     *
     * @link http://laravel.com/docs/5.0/eloquent#many-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendRequests()
    {
        return $this->belongsToMany('StartMeUp\User');
    }

    /**
     * One-to-Many.
     *
     * @link http://laravel.com/docs/5.0/eloquent#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goals()
    {
        return $this->hasMany('StartMeUp\Models\Goal');
    }

    /**
     * Many-to-Many.
     *
     * @link http://laravel.com/docs/5.0/eloquent#many-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interests()
    {
        return $this->belongsToMany('StartMeUp\Models\Interest');
    }

    /**
     * One-to-Many.
     *
     * @link http://laravel.com/docs/5.0/eloquent#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany('StartMeUp\Models\Location');
    }

    /**
     * One-to-Many.
     *
     * @link http://laravel.com/docs/5.0/eloquent#one-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moods()
    {
        return $this->hasMany('StartMeUp\Models\Mood');
    }
    /**
     * Many-to-Many.
     *
     * @link http://laravel.com/docs/5.0/eloquent#many-to-many
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rewards()
    {
        return $this->belongsToMany('StartMeUp\Models\Reward');
    }

    /**
     * One-to-One.
     *
     * @link http://laravel.com/docs/5.0/eloquent#one-to-one
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings()
    {
        return $this->hasOne('StartMeUp\Models\Settings');
    }
}
