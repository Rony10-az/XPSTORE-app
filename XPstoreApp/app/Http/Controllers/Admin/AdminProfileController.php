<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // ← FALTA ESTE IMPORT
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Mostrar el perfil del administrador
     */
    public function index()
    {
        try {

            /** @var User $admin */
            $admin = Auth::user();

            if (!$admin) {
                return redirect()->route('login')->with('error', 'Debes iniciar sesión');
            }

            return view('admin.profile.index', compact('admin'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.admin')
                ->with('error', 'Error al cargar el perfil: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar los datos básicos del administrador
     */
    public function updateProfile(Request $request)
    {
        /** @var User $admin */
        $admin = Auth::user(); // ← MUEVO ESTO FUERA DEL TRY (IMPORTANTE)

        try {

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
                'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            ]);

            // Manejar la carga del avatar
            if ($request->hasFile('avatar')) {

                // Eliminar avatar anterior si existe
                if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                    Storage::disk('public')->delete($admin->avatar);
                }

                // Guardar nuevo avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $avatarPath;
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.profile.index')
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }

        // ACTUALIZACIÓN DIRECTA POR QUERY BUILDER
        DB::table('users')->where('id', $admin->id)->update($validated);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Actualizar la contraseña del administrador
     */
    public function updatePassword(Request $request)
    {
        /** @var User $admin */
        $admin = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Eliminar el avatar del administrador
     */
    public function deleteAvatar()
    {
        /** @var User $admin */
        $admin = Auth::user();

        if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
            Storage::disk('public')->delete($admin->avatar);
        }

        $admin->update(['avatar' => null]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Avatar eliminado correctamente');
    }
}
