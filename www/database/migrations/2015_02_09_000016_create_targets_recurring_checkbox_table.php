<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use StartMeUp\Models\TargetRecurringCheckbox;

class CreateTargetsRecurringCheckboxTable extends Migration
{
    const TABLE = 'targets_recurring_checkbox';

    const PK = 'id';

    const FK = 'target_id';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            // Meta Data
            $table->increments(self::PK);
            $table->timestamps();  // 'created_at', 'updated_at'
            $table->softDeletes(); // 'deleted_at'

            // Foreign Keys

            // Data
            $table->date('deadline_date');
            $table->time('deadline_time');
            $table->boolean('deadline_reminder')
                ->default(false);
            $table->enum('repeat_deadline', TargetRecurringCheckbox::REPEATS)
                ->nullable();
            $table->date('repeat_until_date')
                ->nullable();
            $table->time('repeat_until_time')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(self::TABLE);
    }
}
