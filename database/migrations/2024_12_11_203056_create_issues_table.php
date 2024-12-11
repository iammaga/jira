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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('sprint_id')->nullable()->constrained('sprints')->onDelete('set null');
            $table->foreignId('release_id')->nullable()->constrained('releases')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('type_id')->constrained('issue_types')->onDelete('cascade');
            $table->foreignId('priority_id')->constrained('priorities')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->foreignId('assignee_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
