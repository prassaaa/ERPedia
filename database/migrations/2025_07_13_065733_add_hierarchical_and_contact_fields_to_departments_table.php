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
        Schema::table('departments', function (Blueprint $table) {
            // Add hierarchical structure
            $table->foreignId('parent_id')->nullable()->after('company_id')->constrained('departments')->onDelete('set null');

            // Add contact information
            $table->string('email')->nullable()->after('description');
            $table->string('phone')->nullable()->after('email');
            $table->string('location')->nullable()->after('phone');

            // Add indexes
            $table->index(['parent_id']);
            $table->index(['company_id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['company_id', 'parent_id']);
            $table->dropIndex(['parent_id']);

            // Drop foreign key constraint
            $table->dropForeign(['parent_id']);

            // Drop columns
            $table->dropColumn(['parent_id', 'email', 'phone', 'location']);
        });
    }
};
