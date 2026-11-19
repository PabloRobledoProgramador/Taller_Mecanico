<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Los clientes no son usuarios: el rol 'cliente' ya no existe.
        DB::table('users')->where('role', 'cliente')->update(['role' => 'mecanico']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('mecanico')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('cliente')->change();
        });
    }
};
