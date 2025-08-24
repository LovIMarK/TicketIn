<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * Create the messages table.
 *
 * Columns:
 * - id         : bigint primary key
 * - content    : message body (text)
 * - created_at : defaults to CURRENT_TIMESTAMP
 * - updated_at : CURRENT_TIMESTAMP with ON UPDATE
 * - ticket_id  : FK -> tickets.id (cascade on delete)
 * - user_id    : FK -> users.id (cascade on delete)
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
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreignId('ticket_id')
                ->constrained()->
                cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
