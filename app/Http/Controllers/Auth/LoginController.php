<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('pastas', $request->get('pastas'))->first();
        if ($user) {
            if (Hash::check($request->get('slaptazodis'), $user->slaptazodis)) {
                Auth::guard('web')->login($user);
                return redirect()->intended($this->redirectTo);
            }
        }

        return redirect()->back()->with('error', 'Neteisingas vartotojo vardas ir/arba slaptazodis');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::guard()->logout();

        return redirect('/');
    }
}
