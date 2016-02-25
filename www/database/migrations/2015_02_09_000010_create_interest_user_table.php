<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestUserTable extends Migration
{
    const TABLE = 'interest_user';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            // Primary Key
            $table->unsignedInteger(CreateInterestsTable::FK);
            $table->unsignedInteger(CreateUsersTable::FK);
            $table->primary([CreateInterestsTable::FK, CreateUsersTable::FK]); // Composite Key.

            // Foreign Keys
            $table->foreign(CreateInterestsTable::FK)
                ->references(CreateInterestsTable::PK)
                ->on(CreateInterestsTable::TABLE);
            $table->foreign(CreateUsersTable::FK)
                ->references(CreateUsersTable::PK)
                ->on(CreateUsersTable::TABLE)
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
