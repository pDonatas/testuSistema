<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function create(RegistrationRequest $data)
    {
        $user = new User();
        $user->fill([
            'vardas' => $data['vardas'],
            'pastas' => $data['pastas'],
            'slaptazodis' => Hash::make($data['slaptazodis']),
            'pavarde' => $data['pavarde']
        ]);
        $user->save();

        Auth::guard('web')->login($user);

        return redirect($this->redirectTo);
    }

    public function index()
    {
        return view('auth.register');
    }
}
