<?php

namespace App\Http\Livewire\Auth;

use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $name = 'huy';

    /** @var string */
    public $companyName = 'Laracast';

    /** @var string */
    public $email = 'nguyenlehuyuit@gmail.com';

    /** @var string */
    public $password = 'password';

    /** @var string */
    public $passwordConfirmation = '';

    protected $rules = [
        'name' => ['required'],
        'email' => ['required', 'email', 'unique:users'],
        'companyName' => ['required', 'min:3', 'unique:tenants,name', 'string'],
        'password' => ['required', 'same:passwordConfirmation'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $this->validate();

        $tenant = Tenant::create([
            'name' => $this->companyName,
        ]);

        $user = User::create([
            'email' => $this->email,
            'name' => $this->name,
            'role' => 'Admin',
            'password' => Hash::make($this->password),
            'tenant_id' => $tenant->id
        ]);

//        $user->tenant()->associate()

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
