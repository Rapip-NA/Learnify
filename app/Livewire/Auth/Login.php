<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{

    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    #[Layout('components.layouts.auth-custom')]

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $credentials = $this->validate();

        if (Auth::attempt($credentials)) {
            session()->regenerate();

            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'qualifier') {
                return redirect()->intended('/qualifier/dashboard'); 
            } else {
                return redirect()->intended('/peserta/dashboard');
            }
        } else {
            $this->addError('email', 'Email atau password salah.');
            $this->addError('password', 'Email atau password salah.');
        }
    }

    public function loginAs($role)
    {
        $user = \App\Models\User::where('role', $role)->first();
        if ($user) {
            Auth::login($user);
            session()->regenerate();

            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'qualifier') {
                return redirect()->intended('/qualifier/dashboard'); 
            } else {
                return redirect()->intended('/peserta/dashboard');
            }
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
