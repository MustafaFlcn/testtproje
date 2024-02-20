<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('taskss', function (Blueprint $table) {
            $table->id();
            $table->date('task_time');
            $table->string('title');
            $table->text('subject');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('status')->default(0)->comment('0:pasif 1:aktif');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskss');
    }
};
