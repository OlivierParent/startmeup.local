<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Carbon\Carbon;
use StartMeUp\Models\TargetCheckbox;
use StartMeUp\Models\TargetDuration;
use StartMeUp\Models\TargetRecurringCheckbox;
use StartMeUp\Models\UpdateDuration;
use StartMeUp\Models\UpdateRecurringCheckbox;

class TargetableUpdateTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        $iMax = 5;

        $targetsCheckbox = TargetCheckbox::all();
        foreach ($targetsCheckbox as $target) {
            $dates = [
                Carbon::now()->addDay(-3),
                Carbon::now()->addDay(-2),
                Carbon::now()->addDay(-1),
                Carbon::now(),
            ];
            $target->achieved_at = $this->faker->optional($weight = .75, $default = null)->randomElement($dates);
            $target->save();
        }

        $targetsDuration = TargetDuration::all();
        foreach ($targetsDuration as $target) {
            $updates = factory(UpdateDuration::class, $iMax)->make();
            $target->updates()->saveMany($updates);
        }

        $targetsRecurringCheckbox = TargetRecurringCheckbox::all();
        foreach ($targetsRecurringCheckbox as $target) {
            $i = $iMax;
            $updates = factory(UpdateRecurringCheckbox::class, $iMax)
                ->make()
                ->each(function ($update) use (&$i) {
                    --$i;
                    $update->achieved_at = $update->achieved_at->addDay(-$i);
                });
            $target->updates()->saveMany($updates);
        }
    }
}
