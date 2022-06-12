<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
       $request->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
       ]);

       $data = new User;
       $data->name = $request->name;
       $data->email = $request->email;
       $data->password = Hash::make($request->password);
       $data->save();

      if(\Auth::attempt($request->only('email','password'))){
        return redirect('home');
      }
      return redirect('register')->withError('Error');
    }

    public function login()
    {
       return view('login');
    }

    public function auth(Request $request)
    {
       $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
       
        if(\Auth::attempt($request->only('email','password'))){
            return redirect('home');
          }
          return redirect('login')->withError('login are not valid');

    }

    public function home(){
        return view('home');
    }

    public function logout()
    {
        \Session::flush();
        \Auth::logout();
        return redirect('/login');
    }
}
