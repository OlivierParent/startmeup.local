<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Jobs;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use StartMeUp\Models\Settings;
use StartMeUp\User;

class AddSettingsForNewUserJob extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     * @return integer
     */
    public function handle()
    {
        $settings = new Settings();
        $settings->user()->associate($this->user);
        $settings->save();

        return $settings->id;
    }
}
