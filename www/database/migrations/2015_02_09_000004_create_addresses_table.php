<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    const TABLE = 'addresses';

    const PK = 'id';

    const FK = 'address_id';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            // Meta Data
            $table->increments('id');
            $table->timestamps();  // 'created_at', 'updated_at'
            $table->softDeletes(); // 'deleted_at'

            // Foreign Keys
            $table->unsignedInteger(CreateLocalitiesTable::FK);
            $table->foreign(CreateLocalitiesTable::FK)
                ->references(CreateLocalitiesTable::PK)
                ->on(CreateLocalitiesTable::TABLE)
                ->onDelete('cascade');

            // Data
            $table->string('street');
            $table->string('extended')
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
