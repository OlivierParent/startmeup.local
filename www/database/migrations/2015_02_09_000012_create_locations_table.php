<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use StartMeUp\Models\Location;

class CreateLocationsTable extends Migration
{
    const TABLE = 'locations';

    const PK = 'id';

    const FK = 'location_id';

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
            $table->unsignedInteger(CreateAddressesTable::FK)
                ->nullable();
            $table->foreign(CreateAddressesTable::FK)
                ->references(CreateAddressesTable::PK)
                ->on(CreateAddressesTable::TABLE)
                ->onDelete('cascade');
            $table->unsignedInteger(CreateUsersTable::FK)
                ->nullable();
            $table->foreign(CreateUsersTable::FK)
                ->references(CreateUsersTable::PK)
                ->on(CreateUsersTable::TABLE)
                ->onDelete('cascade');

            // Data
            $table->string('title');
            $table->string('subtitle');
            $table->text('description')
                ->nullable();
            $table->enum('type', Location::TYPES)
                ->default(Location::TYPE_ORG);
            $table->float('latitude', 10, 7);
            $table->float('longitude', 10, 7);
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
