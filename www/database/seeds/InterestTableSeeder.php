<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Interest;

class InterestTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateInterestsTable::TABLE)->delete();

        $leisureInterests = [
            'Art film',
            'Beer tasting',
            'Biking',
            'Boarding (skate)',
            'Boarding (snow)',
            'Box office',
            'Cooking',
            'Documentaries',
            'Flow states',
            'Foodie',
            'Ice skating',
            'Jogging',
            'Knitting',
            'Marathons',
            'Meditation',
            'Museums',
            'Music',
            'Nature walks',
            'Origami',
            'Photography',
            'Practice music',
            'Quiz',
            'Reading',
            'Running',
            'Serie binch watching',
            'Surfing',
            'Tai Chi',
            'Tennis',
            'Triathlon',
            'Video culture',
            'Yoga',
            'Zen states',
        ];

        $professionalInterests = [
            '2D animation',
            '3D animation',
            '3D printing',
            'Accounting',
            'Artisanal business',
            'Crowd funding',
            'Crowd sourcing',
            'Design thinking processes',
            'EU fund raising',
            'Government fund raising',
            'Graffiti',
            'Healthcare applications',
            'Lobbying',
            'Finance',
            'Behaviour design',
            'Development/coding/programming',
            'Design',
            'Networking',
            'Marketing',
            'Media campaigning and planning',
            'Peace innovation',
            'Platform thinker (platforms such as Etsy, Kickstarter …)',
            'Product design',
            'Reading (academic domain specific literature)',
            'Reading (domain specific literature)',
            'Research, ex. relation between human and machine',
            'Sales',
            'Sensor based objects',
            'Smart objects',
            'Smart cities',
            'Social innovation',
            'Technology innovation',
            'User Experience (UX) design',
            'Venture Capital raising',
            'Writing',
        ];

        foreach (array_merge($leisureInterests, $professionalInterests) as $interest) {
            Interest::create([
                'name' => $interest,
            ]);
        }

//        // Faker
//        // -----
//        factory(Interest::class, self::$maxItems)->create();
    }
}
