<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->restrictOnDelete();

            $table->foreignId('mechanic_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('date');
            $table->string('status')->default('en_taller');
            $table->text('job_description');
            $table->decimal('total_cost', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['mechanic_id']);
            $table->dropColumn([
                'vehicle_id',
                'mechanic_id',
                'date',
                'status',
                'job_description',
                'total_cost',
            ]);
        });
    }
};