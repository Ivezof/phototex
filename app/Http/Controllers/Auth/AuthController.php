<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getRegister() {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) {
        $credentials = $request->validated();
        $user = User::create($credentials);
        Debugbar::info($credentials);
        Auth::login($user);
    }

    public function getLogin() {
        return view('auth.login');
    }

    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        Debugbar::info($credentials['login']);
        if (Auth::attempt(['id' => $credentials['code'], 'login' => $credentials['login'],'password' => $credentials['password']])) {
            return redirect()->intended('dashboard');
        }
        return redirect()->route('getLogin')->withErrors(['data_invalid' => 'Неправильная почта, код сотрудника или пароль']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
