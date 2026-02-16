<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
   public function __invoke(Request $request)
    {
        $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            //V1
            // $userRow = DB::select('EXEC sp_AuthenticateUser ?, ?', [
            //     $credentials['email'],
            //     $credentials['password']
            // ]);

            // if (!empty($userRow)) {
            //     // Find or create user instance to authenticate
            //     $user = User::where('email', $userRow[0]->email)->first();

            //     Auth::login($user);

            //     $request->session()->regenerate();
            //     return redirect()->intended('dashboard');
            // }

            // return back()->withErrors([
            //     'email' => 'The provided credentials do not match our records.',
            // ]);

            //V2
            $obtainedUser = DB::select('EXEC sp_GetUserByEmail @Email = ?', [
                $credentials['email']
            ]);

            if(count($obtainedUser) > 0){
                $user = User::find($obtainedUser[0]->id);

                if(Hash::check($credentials['password'], $user-> password)){
                    $remember = $request->filled('remember'); // True if checkbox is checked
                    Auth::login($user, $remember);
                    return redirect()->intended('');
                }
            }
            else{
                return back()->withErrors(['email' => 'Invalid credentials.']);
            }
    }
}
