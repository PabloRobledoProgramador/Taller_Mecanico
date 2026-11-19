<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Si la columna ya existe (por una versión anterior), no se vuelve a crear.
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 20)->default('cliente')->index()->after('password');
            });

            // Los usuarios que ya existían son del taller: quedan como admin
            // (si no, se quedarían sin acceso) y con el correo verificado.
            DB::table('users')->update(['role' => 'admin']);
        }

        // Cuentas creadas desde el panel antes de activar la verificación de correo.
        DB::table('users')->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        // No se elimina 'role' a propósito: podría existir desde antes de esta migración.
    }
};
