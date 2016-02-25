<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use StartMeUp\Models\Goal;

class CreateGoalsTable extends Migration
{
    const TABLE = 'goals';

    const PK = 'id';

    const FK = 'goal_id';

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
            $table->unsignedInteger(CreateCategoriesTable::FK);
            $table->foreign(CreateCategoriesTable::FK)
                ->references(CreateCategoriesTable::PK)
                ->on(CreateCategoriesTable::TABLE);
            $table->unsignedInteger(CreateUsersTable::FK);
            $table->foreign(CreateUsersTable::FK)
                ->references(CreateUsersTable::PK)
                ->on(CreateUsersTable::TABLE)
                ->onDelete('cascade');
            $table->morphs('target');

            // Data
            $table->string('name');
            $table->string('target_class');
            $table->text('notes')
                ->nullable();
            $table->smallInteger('remind')
                ->unsigned()
                ->nullable(); // Minute before
            $table->boolean('in_progress')
                ->default(true)
                ->nullable();
            $table->boolean('share')
                ->default(false); // Share with friends
            $table->enum('priority', Goal::PRIORITIES)
                ->default(Goal::PRIORITY_NORMAL);
            $table->tinyInteger('order')
                ->default(0);
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
