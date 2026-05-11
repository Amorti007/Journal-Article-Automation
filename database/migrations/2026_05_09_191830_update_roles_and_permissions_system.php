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
        // 1. Update old roles to the new 3-role system
        \Illuminate\Support\Facades\DB::table('users')->where('role', 'author')->update(['role' => 'editor']);
        \Illuminate\Support\Facades\DB::table('users')->where('role', 'referee')->update(['role' => 'reader']);

        // 2. Update journals table
        Schema::table('journals', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id'); // Owner Editor
            $table->string('status')->default('pending')->after('description');
        });

        // 3. Update articles table
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('delete_requested')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('delete_requested');
        });

        Schema::table('journals', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status']);
        });
    }
};
