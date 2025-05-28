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
        Schema::table('attemp', function (Blueprint $table) {
            $table->integer('attemp_in_out');
            $table->integer('attemp_type')->default(1);
            $table->string('image')->nullable();
            $table->dropColumn('attemp_in');
            $table->dropColumn('attemp_out');
            $table->dropColumn('attemp_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attemp', function (Blueprint $table) {
            //
        });
    }
};
