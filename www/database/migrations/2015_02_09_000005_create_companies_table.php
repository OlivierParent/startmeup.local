<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    const TABLE = 'companies';

    const PK = 'id';

    const FK = 'company_id';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            // Meta Data
            $table->increments(self::PK);
            $table->timestamps();  // 'created_at', 'updated_at'

            // Foreign Keys
            $table->unsignedInteger(CreateAddressesTable::FK)
                ->nullable();
            $table->foreign(CreateAddressesTable::FK)
                ->references(CreateAddressesTable::PK)
                ->on(CreateAddressesTable::TABLE)
                ->onDelete('cascade');

            // Data
            $table->string('name');
            $table->text('description');
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
