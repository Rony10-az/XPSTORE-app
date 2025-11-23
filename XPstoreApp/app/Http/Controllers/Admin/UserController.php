<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Listado con filtros y métricas.
     */
    public function index(Request $request): View
    {
        // Armé estos filtros básicos para que el admin busque rápido.
        $search = $request->input('search');
        $role = $request->input('role');
        $status = $request->input('status');
        $sort = $request->input('sort', 'recent');

        $usersQuery = User::query();

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $usersQuery->where('role', $role);
        }

        if ($status) {
            $usersQuery->where('status', $status);
        }

        // Decidí permitir ordenar por reciente o último acceso.
        if ($sort === 'last_login') {
            $usersQuery->orderByDesc('last_login_at')->orderByDesc('created_at');
        } else {
            $usersQuery->orderByDesc('created_at');
        }

        $users = $usersQuery->paginate(10)->withQueryString();

        // Reuní métricas rápidas para las tarjetas superiores.
        $metrics = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'blocked' => User::where('status', 'blocked')->count(),
            'recent' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('admin.users.index', compact('users', 'metrics', 'search', 'role', 'status', 'sort'));
    }

    /**
     * Ver detalle de usuario.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Editar rol y estado.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Guardar cambios.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Validé lo esencial que el admin puede cambiar.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,user'],
            'status' => ['required', 'in:active,blocked,pending'],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Evité que un admin se borre a sí mismo por accidente.
        if (auth()->id() === $user->id) {
            return back()->withErrors(['user' => 'No puedes eliminar tu propia cuenta.']);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
