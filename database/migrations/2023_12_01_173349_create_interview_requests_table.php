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
        Schema::create('interview_requests', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('request_user_id');
            $table->foreign('request_user_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('requested_user_id');
            $table->foreign('requested_user_id')->references('id')->on('users');
            
            $table->foreignId('survey_id')
                ->unique()
                ->constrained()
                ->onDelete('cascade');
                
            $table->boolean('accepted')->default(false);
            
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
        Schema::dropIfExists('interview_requests');
    }
};
