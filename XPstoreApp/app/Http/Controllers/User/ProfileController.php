<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $avatarPath = $user->avatar; // default

        // Procesar nueva imagen
        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Guardar en /public/avatars/
            $file->move(public_path('avatars'), $filename);

            // Guardar ruta para BD
            $avatarPath = 'avatars/' . $filename;
        }

        // ACTUALIZAR USANDO "::"
        User::where('id', $user->id)->update([
            'name'   => $request->name,
            'avatar' => $avatarPath,
        ]);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }


    public function ejemplo()
    {
        $usuario = User::find(1);
    }
}
