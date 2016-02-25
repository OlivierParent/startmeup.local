<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use StartMeUp\Models\Settings;

class CreateSettingsTable extends Migration
{
    const TABLE = 'settings';

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

            // Foreign Keys
            $table->unsignedInteger(CreateUsersTable::FK);
            $table->foreign(CreateUsersTable::FK)
                ->references(CreateUsersTable::PK)
                ->on(CreateUsersTable::TABLE)
                ->onDelete('cascade'); // If `users` row is deleted then `settings` rows also.
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('timezone_id');

            // Data
            $table->enum('colour_palette', Settings::COLOUR_PALETTES)
                ->default(Settings::COLOUR_PALETTE_A);
            $table->boolean('share_address')->default(false);
            $table->boolean('share_birthday')->default(false);
            $table->boolean('share_email')->default(false);
            $table->boolean('share_gender')->default(false);
            $table->boolean('share_interests')->default(false);
            $table->boolean('share_locality')->default(false); // City
            $table->boolean('share_location')->default(false); // Current location
            $table->boolean('share_mobile')->default(false);
            $table->boolean('share_picture')->default(false);
            $table->boolean('share_progress')->default(false); // ? goal progress
            $table->boolean('show_notifications')->default(true);
            $table->boolean('want_to_collaborate')->default(false);
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
