<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Userモデルに保存すべき値の取得
        $user_input = $request->input('user');
        // dd($user_input);
        $request->validate([
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:App\Models\User,email'],
            // 'user.password' => ['required', 'confirmed'],
            'user.password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // dd($request);
        $user = User::create([
            'name' => $user_input['name'],
            'email' => $user_input['email'],
            'password' => Hash::make($user_input['password']),
        ]);
        
        // Profileモデルに保存すべき値の取得

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
