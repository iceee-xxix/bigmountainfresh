<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('work_leave_describe');
            $table->date('work_leave_date');
            $table->time('work_leave_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_leaves');
    }
};
