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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',200);
            $table->text('description');
            $table->enum('status', ['open', 'in_progress','resolved', 'closed'])->default('open');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent() ->useCurrentOnUpdate();


            $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('cascade');

            $table->foreignId('agent_id')
            ->nullable()
            ->constrained('users')
            ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
