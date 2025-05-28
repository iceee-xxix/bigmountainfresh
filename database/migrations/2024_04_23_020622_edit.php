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
        Schema::table('work_leaves', function (Blueprint $table) {
            $table->dropColumn('work_leave_approve_type');
            $table->dropColumn('work_leave_approve_time');
            $table->dropColumn('work_leave_status');
            $table->dropColumn('work_leave_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_leaves', function (Blueprint $table) {
            //
        });
    }
};
