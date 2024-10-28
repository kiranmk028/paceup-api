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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('status', ['backlog', 'to_do', 'in_development', 'in_review', 'deployed', 'closed']);
            $table->enum('priority', ['urgnet', 'high', 'normal', 'low']);
            $table->enum('sprint_point', [1, 2, 3, 4, 5, 6, 7, 8, 9]);
            $table->timestamp('due_date');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('p_list_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
