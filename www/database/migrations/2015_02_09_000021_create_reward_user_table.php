<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardUserTable extends Migration
{
    const TABLE = 'reward_user';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            // Primary Key
            $table->unsignedInteger(CreateRewardsTable::FK);
            $table->unsignedInteger(CreateUsersTable::FK);
            $table->primary([CreateRewardsTable::FK, CreateUsersTable::FK]); // Composite Key.

            // Foreign Keys
            $table->foreign(CreateRewardsTable::FK)
                ->references(CreateRewardsTable::PK)
                ->on(CreateRewardsTable::TABLE);
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
