<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $photo = $data['photo'] ?? null;

        unset($data['photo']);

        // Solo actualiza el nombre; el correo queda intacto.
        $user->fill($data);

        $oldPhotoPath = $user->profile_photo_path;

        if ($photo) {
            $newPhotoPath = $photo->store('profile-photos', 'public');

            if ($newPhotoPath === false) {
                throw new \RuntimeException('No se pudo guardar la foto de perfil.');
            }

            $user->profile_photo_path = $newPhotoPath;
        }

        $user->save();

        if ($photo && $oldPhotoPath) {
            Storage::disk('public')->delete($oldPhotoPath);
        }

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
