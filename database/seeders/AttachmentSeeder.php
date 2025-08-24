<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attachment;

/**
 * Seeds the attachments table.
 *
 * Uses the Attachment factory to generate sample records for development/testing.
 */
class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates 50 attachments.
     *
     * @return void
     */
    public function run(): void
    {
        Attachment::factory(50)->create();
    }
}
