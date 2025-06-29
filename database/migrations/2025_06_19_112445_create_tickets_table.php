<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->uuid('uuid')->unique();
            $table->enum('priority', ['low', 'medium', 'high'])->nullable()->default(null);
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent() ->useCurrentOnUpdate();
            $table->timestamp('closed_at')->nullable();


            $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('cascade');

            $table->foreignId('agent_id')
            ->nullable()
            ->constrained('users')
            ->onDelete('set null');

        });

        DB::statement('
            ALTER TABLE tickets
            ADD CONSTRAINT chk_priority_status
            CHECK (
                priority IS NOT NULL
                OR status = "open"
            )
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
