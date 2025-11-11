<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Inyecta AuthService para delegar la lógica de autenticación.
     */
    public function __construct(private readonly AuthService $auth) {}

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
        $user = $this->auth->attempt($request->get('email'), $request->get('password'));

        if (!$user) {
            return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
        }

        return redirect()->route('dashboard')->with('success', 'Bienvenido');
    }

    /**
     * Procesar registro de nuevo usuario.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        try {
            $this->auth->register($request->get('name'), $request->get('email'), $request->get('password'));
            return redirect()->route('dashboard')->with('success', 'Cuenta creada');
        } catch (\RuntimeException $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Cerrar la sesión del usuario.
     */
    public function logout(): RedirectResponse
    {
        $this->auth->logout();
        return redirect()->route('login')->with('success', 'Sesión cerrada');
    }
}
