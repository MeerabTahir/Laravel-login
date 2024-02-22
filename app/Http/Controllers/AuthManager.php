<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthManager extends Controller
{
    function login(){
        return view('login');
    }
    function registration(){
        return view('registration');
    }
    function loginPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'

        ]);
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('home'));
    }
    return redirect()->intended(route('login'))->with('error','Login details are invalid');
}
    function registrationPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);
        $data['name'] =$request ->name;
        $data['email'] =$request ->email;
        $data['password'] = Hash::make($request ->password);
        $user = User::create($data);
        if(!$user){
            return redirect()->intended(route('registration'))->with('error','Registration Failed, try again.');
        }
        return redirect()->intended(route('login'))->with('success','Registration is successful. Login to access the app');
    }

    // function logout(){
    //     Session::flush();
    //     Auth:logout();
    //     return redirect(route('login'));
    // }

}