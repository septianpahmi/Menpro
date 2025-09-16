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
        Schema::create('finance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['CF', 'DP', 'Deadline SPH', 'Deadline Design', 'Deadline DED', 'Deadline Produksi', 'Deadline Pemasangan']);
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->date('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_schedules');
    }
};
