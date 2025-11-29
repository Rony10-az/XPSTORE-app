<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    public function index()
    {
        // MANEJO DE ERRORES AL CARGAR PERFIL
        try {
            $admin = Auth::user();
            // Verificar si el usuario autenticado es un administrador
            if (!$admin) {
                return redirect()->route('login')->with('error', 'Debes iniciar sesión');
            }
            // Mostrar vista de perfil
            return view('admin.profile.index', compact('admin'));
            // FIN MANEJO DE ERRORES
        } catch (\Exception $e) {
            return redirect()->route('dashboard.admin')
                ->with('error', 'Error al cargar el perfil: ' . $e->getMessage());
        }
    }

    public function updateProfile(Request $request)
    {
        // MANEJO DE ERRORES AL ACTUALIZAR PERFIL
        try {
            $admin = Auth::user();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
                'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
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

    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Guardar nueva contraseña usando Query Builder
        DB::table('users')
            ->where('id', $admin->id)
            ->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Contraseña actualizada correctamente');
    }

    public function deleteAvatar()
    {
        $admin = Auth::user();

        // Eliminar archivo si existe
        if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
            Storage::disk('public')->delete($admin->avatar);
        }

        // Remover avatar de la BD
        DB::table('users')->where('id', $admin->id)->update(['avatar' => null]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Avatar eliminado correctamente');
    }
}
