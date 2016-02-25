<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdatesRecurringCheckboxTable extends Migration
{
    const TABLE = 'updates_recurring_checkbox';

    const PK = 'id';

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
            $table->unsignedInteger(CreateTargetsRecurringCheckboxTable::FK);
            $table->foreign(CreateTargetsRecurringCheckboxTable::FK)
                ->references(CreateTargetsRecurringCheckboxTable::PK)
                ->on(CreateTargetsRecurringCheckboxTable::TABLE)
                ->onDelete('cascade');

            // Data
            $table->timestamp('achieved_at');

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
