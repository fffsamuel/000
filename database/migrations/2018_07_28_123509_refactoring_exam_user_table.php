<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactoringExamUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_user', function ($table){
           $table->dropForeign(['question_id']);
           $table->renameColumn('question_id','exam_id');
           $table->foreign('exam_id')
               ->references('id')
               ->on('exams')
               ->onDelete('cascade');
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
            $table->dropForeign(['exam_id']);
            $table->renameColumn('exam_id','question_id');
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade');
        });
    }
}
