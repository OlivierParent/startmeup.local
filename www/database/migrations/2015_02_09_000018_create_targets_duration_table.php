<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use StartMeUp\Models\TargetDuration;

class CreateTargetsDurationTable extends Migration
{
    const TABLE = 'targets_duration';

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
            $table->smallInteger('time_estimated') // Multiplied by time_increment (in minutes).
                ->unsigned();
            $table->enum('time_increment', TargetDuration::TIME_INCREMENTS);
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
