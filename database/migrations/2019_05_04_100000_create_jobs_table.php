<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
			$table->increments('id')->unique();
            $table->integer('candidate_id');
			//$table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
            $table->string('title');
            $table->string('company');
            $table->timestamp('start_date')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_date')->default(\DB::raw('CURRENT_TIMESTAMP'));
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
