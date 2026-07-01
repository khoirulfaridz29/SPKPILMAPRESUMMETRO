<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubrik_custom_templates', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template');
            $table->timestamps();
        });

        Schema::create('rubrik_custom_template_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('rubrik_custom_templates')->cascadeOnDelete();
            $table->string('nama_field');
            $table->enum('tipe_input', ['text', 'number', 'textarea', 'score_range']);
            $table->integer('urutan')->default(0);
            $table->decimal('bobot', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubrik_custom_template_fields');
        Schema::dropIfExists('rubrik_custom_templates');
    }
};
