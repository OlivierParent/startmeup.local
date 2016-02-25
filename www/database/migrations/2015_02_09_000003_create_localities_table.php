<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalitiesTable extends Migration
{
    const TABLE = 'localities';

    const PK = 'id';

    const FK = 'locality_id';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            // Meta Data
            $table->increments('id');

            // Foreign Keys
            $table->unsignedInteger(CreateRegionsTable::FK)
                ->nullable();
            $table->foreign(CreateRegionsTable::FK)
                ->references(CreateRegionsTable::PK)
                ->on(CreateRegionsTable::TABLE)
                ->onDelete('set null');

            // Data
            $table->string('postal_code');
            $table->string('name');
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
