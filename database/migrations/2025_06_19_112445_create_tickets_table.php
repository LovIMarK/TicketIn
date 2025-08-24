<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


/**
 * Create the tickets table.
 *
 * Columns:
 * - id        : bigint primary key
 * - title     : ticket title (max 200 chars)
 * - uuid      : unique identifier used for routing/binding
 * - priority  : low | medium | high | null
 * - status    : open | in_progress | resolved | closed (default: open)
 * - created_at/updated_at with CURRENT_TIMESTAMP and ON UPDATE
 * - closed_at : nullable timestamp for closed tickets
 * - user_id   : creator (FK -> users.id, cascade on delete)
 * - agent_id  : assigned agent (nullable FK -> users.id, set null on delete)
 *
 * Additional constraint:
 * - chk_priority_status: if priority is null, status must be 'open'
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('agent_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        });
        // Enforce business rule: tickets without a priority must remain 'open'.
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
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
