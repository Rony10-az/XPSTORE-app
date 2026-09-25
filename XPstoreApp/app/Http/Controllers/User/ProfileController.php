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

        $avatarPath = $user->avatar; // por defecto conserva el mismo avatar

        // Subir nueva imagen
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }


        User::where('id', $user->id)->update([
            'name' => $request->name,
            'avatar' => $avatarPath
        ]);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }



    public function ejemplo()
    {
        $usuario = User::find(1);
    }
}
