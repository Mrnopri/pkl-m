<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_template_id')->constrained('letter_templates')->onDelete('cascade');
            $table->string('letter_number'); // e.g., "Tel. 43/PS 0000/R1W-KD2000/00/2024"
            $table->string('recipient_name'); // Kepada
            $table->string('reference_number')->nullable(); // Surat saudara nomor
            $table->date('letter_date'); // Tanggal surat
            $table->text('purpose')->nullable(); // Untuk pelaksanaan
            $table->string('duration')->nullable(); // Selama berapa lama
            $table->date('start_date')->nullable(); // Mulai tanggal
            $table->date('end_date')->nullable(); // Sampai tanggal
            $table->date('pkl_start_date')->nullable(); // Awal mulai PKL
            $table->string('signatory_name'); // Nama penandatangan
            $table->string('signatory_position')->nullable(); // Jabatan penandatangan
            $table->string('signatory_nik')->nullable(); // NIK penandatangan
            $table->string('signature_path')->nullable(); // Path to signature image
            $table->json('custom_data')->nullable(); // Any additional custom fields
            $table->longText('generated_content')->nullable(); // Final HTML content
            $table->string('pdf_path')->nullable(); // Path to generated PDF
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
