<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            $table->foreign('survey_id')
                ->references('id')->on('surveys')
                ->onDelete('cascade');
        });
        
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
        });
        
        Schema::table('delivered', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
            $table->foreign('survey_id')
                ->references('id')->on('surveys')
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
        //
    }
};
