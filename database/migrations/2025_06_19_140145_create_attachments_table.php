<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * Create the attachments table.
 *
 * Columns:
 * - id         : bigint primary key
 * - file_name  : original filename (max 255)
 * - file_path  : storage path (max 512)
 * - file_type  : MIME type (max 100)
 * - created_at : defaults to CURRENT_TIMESTAMP
 * - updated_at : CURRENT_TIMESTAMP with ON UPDATE
 * - message_id : FK -> messages.id (cascade on delete)
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
        Schema::create('attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name', 255);
            $table->string('file_path', 512);
            $table->string('file_type', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreignId('message_id')
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
        Schema::dropIfExists('attachments');
    }
};
