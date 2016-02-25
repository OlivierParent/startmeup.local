<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use StartMeUp\Models\Interest;
use StartMeUp\User;

class SaveUserInterestsJob extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @param User  $user
     * @param array $interests
     */
    public function __construct(User $user, array $interests = [])
    {
        $this->user = $user;
        $this->interests = $interests;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $interests = [];
        foreach ($this->interests as $interestData) {
            if (isset($interestData['id'])) {
                $interest = Interest::find($interestData['id']);
                if ($interest) {
                    array_push($interests, $interest);
                }
            } elseif (isset($interestData['name'])) {
                $interest = new Interest();
                $interest->name = $interestData['name'];
                array_push($interests, $interest);
            }
        }

        if (!empty($interests)) {
            $this->user->interests()->saveMany($interests);
        }
    }
}
