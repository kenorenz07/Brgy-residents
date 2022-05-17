<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->constrained('households');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('suffix');
            $table->date('birthday');
            $table->integer('age');
            $table->enum('civil_status',["married", "single", "divorced", "widowed","separated"]);
            $table->string('contact_number');
            $table->string('purok');
            $table->boolean('vaccinated');
            $table->string('vaccine_name')->nullable();
            $table->string('dose')->nullable();
            $table->boolean('is_four_pis_member')->default(0);
            $table->boolean('is_senior_member')->default(0);
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
        Schema::dropIfExists('residents');
    }
}
