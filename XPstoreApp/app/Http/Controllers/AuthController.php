<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthController extends Controller
{
    private AuthService $auth;

    /**
     * Inyecta AuthService para delegar la lógica de autenticación.
     */
    public function __construct()
    {
        $this->auth = new AuthService();
    }

    /**
     * Mostrar formulario de login.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Mostrar formulario de registro.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Procesar envío del formulario de login.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $user = $this->auth->attempt(
            $request->input('email'),
            $request->input('password')
        );

        if (!$user) {
            // Agregué este mensaje para aclarar si la cuenta está bloqueada o pendiente.
            return back()
                ->withErrors(['email' => 'Cuenta no disponible o credenciales incorrectas.'])
                ->withInput($request->only('email'));
        }

        // ⭐ INICIAR SESIÓN EN LARAVEL ⭐
        Auth::login($user);

        // Regenerar sesión (seguro)
        $request->session()->regenerate();

        // Mensaje según rol
        $message = $user->role === 'admin'
            ? '¡Bienvenido Admin!'
            : '¡Bienvenido a XP Store, ' . $user->name . '!';

        // Redirigir por rol
        return $user->role === 'admin'
            ? redirect()->route('dashboard.admin')->with('success', $message)
            : redirect()->route('dashboard.user')->with('success', $message);
    }


    /**
     * Procesar registro de nuevo usuario.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        try {
            $user = $this->auth->register(
                $request->input('name'),
                $request->input('email'),
                $request->input('password')
            );

            // Un nuevo usuario siempre será "user"
            return redirect()
                ->route('dashboard.user')
                ->with('success', '¡Cuenta creada exitosamente! Bienvenido ' . $user->name);
        } catch (\RuntimeException $e) {
            return back()
                ->withErrors(['email' => $e->getMessage()])
                ->withInput($request->only('name', 'email'));
        }
    }

    /**
     * Cerrar la sesión del usuario.
     */
    public function logout(): RedirectResponse
    {
        $this->auth->logout();

        return redirect()
            ->route('login')
            ->with('success', 'Sesión cerrada correctamente');
    }
}
