<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */

namespace StartMeUp\Jobs;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use StartMeUp\Models\Category;
use StartMeUp\Models\Goal;
use StartMeUp\Models\TargetCheckbox;
use StartMeUp\Models\TargetDuration;
use StartMeUp\Models\TargetRecurringCheckbox;
use StartMeUp\User;

class AddDefaultGoalsForNewUserJob extends Job implements SelfHandling
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
     */
    public function handle()
    {
        $categoryOrder = 0;
        foreach (Category::DEFAULT_CATEGORIES as $categoryData) {
            $category = Category::create($categoryData);
            $category->order = $categoryOrder++;
            $category->user()->associate($this->user);
            $category->save();

            $goalsData = Goal::DEFAULT_GOALS[$category['name']];
            $goalOrder = 0;
            foreach ($goalsData as $goalData) {
                switch ($goalData['target_class']) {
                    case 'TargetCheckbox':
                        $target = new TargetCheckbox();
                        break;
                    case 'TargetRecurringCheckbox':
                        $target = new TargetRecurringCheckbox();
                        break;
                    case 'TargetDuration':
                        $target = new TargetDuration();
                        break;
                    default:
                        throw new Exception('Target class not found!');
                        break;
                }
                $target->save();

                $goal = new Goal($goalData);
                $goal->order = $goalOrder++;
                $goal->user()->associate($this->user);
                $goal->category()->associate($category);
                $goal->target()->associate($target);
                $goal->save();
            }
        }
    }
}
