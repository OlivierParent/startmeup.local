<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use StartMeUp\User;

class CreateUsersTable extends Migration
{
    const TABLE = 'users';

    const PK = 'id';

    const FK = 'user_id';
    const FK_FRIEND = 'friend_id';

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
            $table->unsignedInteger(CreateCompaniesTable::FK)
                ->nullable();
            $table->foreign(CreateCompaniesTable::FK)
                ->references(CreateCompaniesTable::PK)
                ->on(CreateCompaniesTable::TABLE)
                ->onDelete('cascade');

            // Data
            $table->string('name');
            $table->string('email')
                ->unique();
            $table->string('password', 60);
            $table->rememberToken();
            $table->string('given_name');
            $table->string('family_name');
            $table->enum('gender', User::GENDERS)
                ->nullable();
            $table->date('birthday')
                ->nullable();
            $table->string('mobile', 15);
            $table->string('picture', 255)
                ->nullable();
            $table->text('biography')
                ->nullable();
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
