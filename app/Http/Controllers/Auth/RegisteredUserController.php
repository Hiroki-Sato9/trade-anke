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

use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register')->with(['genders' => DB::table('genders')->get()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // モデルごとに必要な値の取得
        $user_input = $request->input('user');
        $profile_input = $request->input('profile');
        
        $request->validate([
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:App\Models\User,email'],
            'user.password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->validate([
            'profile.gender_id' => ['required', 'numeric'],
            'profile.age' => ['required', 'numeric', 'min:1'],
        ]);
        
        $user = User::create([
            'name' => $user_input['name'],
            'email' => $user_input['email'],
            'password' => Hash::make($user_input['password']),
        ]);
        
        $user->profile()->create($profile_input);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
