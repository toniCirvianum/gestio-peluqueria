<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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



    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'first_name' => ['required', 'string', 'max:50'],
                'last_name' => ['required', 'string', 'max:100'],
                'username' => ['required', 'string', 'max:50', 'unique:users'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:15'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'role_id' => 2,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'password' => Hash::make($request->password),
                'verified' => 1, // provisional
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('home', absolute: false))->with('success', 'Usuari registrat correctament.');
        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error en registrar l\'usuari: ' . $e->getMessage());
        }
    }

}
