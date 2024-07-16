<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rules\Password;
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

    $request->validate([
        'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_num','min:5','max:20',
    ],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'password' => ['required','confirmed', Password::min(8) // Minimum length of 8 characters
                ->mixedCase() // Must include both uppercase and lowercase letters
                ->letters() // Must include at least one letter
                ->numbers() // Must include at least one number
                ->symbols() // Must include at least one symbol
                ->uncompromised(), // Ensure the password has not been compromised in data breaches
                ],
            ]);

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Crypt::encryptString($request->password), // Encrypting the password
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', false)); // Redirect to dashboard
    }
}
