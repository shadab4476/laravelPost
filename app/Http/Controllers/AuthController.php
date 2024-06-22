<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class AuthController extends Controller
{
    //
    public function registerGet()
    {
        return view("auth.register");
    }

    public function loginGet()
    {
        return view("auth.login");
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "unique:users,email|email|required",
            "password" => "min:4|required",
        ]);

        User::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "password" => bcrypt($request->input('password')),
        ]);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);
        $credential = array("email" => $request->input('email'), "password" => $request->input('password'));
        if (auth()->attempt($credential)) {
            $user = auth()->user();
            $email = $request->input('email');
            $this->send_email($email, $user);
            return redirect()->route('getverify.otp')->with(["status" => "otp sent."]);
        }

        return redirect()->back()->with(["status" => "credential not match!!"]);
    }
    public function resendOtp()
    {
        if (auth()->check()) {
            $this->send_email(auth()->user()->email, auth()->user());
            return response()->json([
                "status" => true
            ]);
        }
    }
    public function send_email($email, $user)
    {
        session()->put("otp_email", rand("111111", "999999"));
        $user->otp = session()->get("otp_email");
        Mail::to($email)->send(new AuthMail($user));
    }


    public function getVerifyOtp()
    {
        return view('auth.verify_otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            "otp" => "required",
        ]);
        if ($request->input('otp') == session('otp_email')) {
            session()->put('verified_mobile_otp', "verified_mobile_otp session created successfuly..");
            return redirect()->route('home');
        }
        return redirect()->back()->with(["status" => "Please enter a correct otp"]);
    }

    public function logout()
    {
        session()->flush();
        auth()->logout();
        return redirect()->route('login');
    }
}
