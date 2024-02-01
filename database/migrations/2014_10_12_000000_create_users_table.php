<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name')->nullable();
            $table->boolean('gender_id')->unsigned();
            $table->uuid('sire_id')->nullable();
            $table->uuid('dam_id')->nullable();
            // $table->uuid('parent_id')->nullable();
            $table->string('dob')->nullable(); //date
            $table->string('titles_before_name')->nullable();
            $table->string('titles_after_name')->nullable();
            $table->string('registration_numbers')->nullable();
            $table->string('ems_color')->nullable();
            $table->string('breed')->nullable();
            $table->string('chip_number')->nullable();
            $table->string('genetic_tests')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cats');
    }
}
