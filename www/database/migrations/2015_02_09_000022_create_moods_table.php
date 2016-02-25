<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use StartMeUp\Models\Mood;

class CreateMoodsTable extends Migration
{
    const TABLE = 'moods';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            // Meta Data
            $table->increments('id');
            $table->timestamps();

            // Foreign Keys
            $table->unsignedInteger(CreateUsersTable::FK);
            $table->foreign(CreateUsersTable::FK)
                ->references(CreateUsersTable::PK)
                ->on(CreateUsersTable::TABLE);

            // Data
            $table->enum('feeling', Mood::FEELINGS);
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
