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
    Schema::create('repairs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
        $table->date('date');
        $table->string('status')->default('en_taller');
        $table->text('job_description');
        $table->decimal('total_cost', 10, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
