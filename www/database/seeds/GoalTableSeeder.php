<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Category;
use StartMeUp\Models\Goal;
use StartMeUp\Models\TargetCheckbox;
use StartMeUp\Models\TargetRecurringCheckbox;
use StartMeUp\Models\TargetDuration;
use StartMeUp\User;

class GoalTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateGoalsTable::TABLE)->delete();
        DB::table(CreateTargetsCheckboxTable::TABLE)->delete();
        DB::table(CreateTargetsRecurringCheckboxTable::TABLE)->delete();
        DB::table(CreateTargetsDurationTable::TABLE)->delete();

        $user = User::first();
        $categories = Category::where('user_id', $user->id)->get();

        foreach ($categories as $category) {
            $category = $categories->where('name', $category['name'])->first();
            $goalsData = Goal::DEFAULT_GOALS[$category['name']];

            $order = 0;
            foreach ($goalsData as $goalData) {

                // @todo: Remove temporary placeholder when real notes are added.
                if (empty($goalData['notes'])) {
                    $goalData['notes'] = $this->faker->paragraph($sentences = 3);
                }

                switch ($goalData['target_class']) {
                    case 'TargetCheckbox':
                        $target = factory(TargetCheckbox::class)->make();
                        break;
                    case 'TargetRecurringCheckbox':
                        $target = factory(TargetRecurringCheckbox::class)->make();
                        break;
                    case 'TargetDuration':
                        $target = factory(TargetDuration::class)->make();
                        break;
                    default:
                        throw new Exception('Target class not found!');
                        break;
                }
                $target->save();

                $goal = new Goal($goalData);
                $goal->order = $order++;
                $goal->category()->associate($category);
                $goal->target()->associate($target);
                $goal->user()->associate($user);
                $goal->save();
            }
        }
    }
}
