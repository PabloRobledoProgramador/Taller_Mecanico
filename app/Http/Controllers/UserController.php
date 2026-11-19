<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.users.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('pages.users.create', [
            'user' => new User(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::enum(Role::class)],
        ]);

        $role = Role::from($data['role']);
        unset($data['role']);

        // El modelo User ya cifra automáticamente la contraseña.
        $user = new User($data);
        $user->role = $role;
        // Cuenta creada por un admin: se considera verificada.
        $user->email_verified_at = now();
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario registrado.');
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::enum(Role::class)],
        ]);

        $role = Role::from($data['role']);
        unset($data['role']);

        // Evita que un admin se quite el rol a sí mismo y se quede sin acceso.
        if ($request->user()->is($user) && $role !== $user->role) {
            return redirect()
                ->route('users.edit', $user)
                ->with('error', 'No puedes cambiar tu propio rol.');
        }

        // Si dejaron la contraseña en blanco, se conserva la existente.
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);
        $user->changeRole($role);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->is($user)) {
            return redirect()
                ->route('users.index')
                ->with('error', 'No puedes eliminar la cuenta con la que has iniciado sesión.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado.');
    }
}
