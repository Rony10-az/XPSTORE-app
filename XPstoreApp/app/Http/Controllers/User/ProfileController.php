<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('store.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'nickname' => 'nullable|string|max:255|unique:users,nickname,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            ]);

            $data = [
                'name' => $validated['name'],
                'nickname' => $validated['nickname'],
                'email' => $validated['email'],
            ];

            $avatarUrl = null;

            // Subir nueva imagen
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                // Eliminar avatar anterior si existe
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
                $avatarUrl = asset('storage/' . $avatarPath);
            }

            $user->update($data);

            // Si es una petición AJAX (cambio de avatar)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Avatar actualizado correctamente',
                    'avatar_url' => $avatarUrl
                ]);
            }

            return back()->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualizar el perfil.']);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            
            User::where('id', $user->id)->update([
                'avatar' => null
            ]);
        }

        return back()->with('success', 'Avatar eliminado correctamente.');
    }
}