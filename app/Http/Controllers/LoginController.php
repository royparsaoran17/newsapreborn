<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

  public function login()
  {
      return view('login');
  }

  public function login_action(Request $request)
  {
      $request->validate([
          'email' => 'required',
          'password' => 'required',
      ]);
      
      if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
          $request->session()->regenerate();
          $user = User::where('email', $request->email)
                    ->get();
            session(['user_id' => $user[0]->id]);
          if($request->email == "admin@email.com"){  
            session(['roles' => "ADMIN"]);
            return redirect()->intended('/quotation');
          }else{
            session(['roles' => "USER"]);
            return redirect()->intended('user/quotation');
          }
      }

      return back()->withErrors([
          'password' => 'Wrong username or password',
      ]);
  }
  
    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/login');
    }

    public function register()
    {
        return view('/register');
    }

    public function register_action(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        // dd($user);
        return view('login');
    }
}
