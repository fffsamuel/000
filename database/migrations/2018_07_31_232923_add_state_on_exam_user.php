<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateOnExamUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_user', function ($table){
            $table->enum('state', ['IN_PROGRESS','COMPLETED'])->default('IN_PROGRESS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_user', function ($table){
            $table->dropColumn('state');
        });
    }
}
