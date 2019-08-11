<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $this->validate($request,
            [
               'name' =>'required',
                'email' => 'required|email|unique:users',
                'password'=> 'required|max:255|min:4'
            ]);

       $user =  User::add($request->all());
       $user->generatePasswordHash($request->get('password'));
       return redirect('/login');
    }

    public function loginForm()
    {
        return view('pages.login');
    }



    public function login(Request $request)
    {

        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

        if( Auth::attempt(
            [
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ]
        ))
        {
         return redirect('/');
        }
        return redirect()->back()->with('status','Невірний логін або пароль');


    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
