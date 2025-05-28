<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use NSRU\App;
use NSRU\DataCore;
use NSRU\MyAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $appId;
    private $appSecret;
    private App $app;
    private MyAuth $myauth;
    private DataCore $dc;

    public function __construct()
    {
        $this->appId = env('NSRU_APP_ID');
        $this->appSecret = env('NSRU_APP_SECRET');
        $this->app = new App($this->appId, $this->appSecret);
        $this->myauth = $this->app->createMyAuth();
        $this->dc = $this->app->createDataCore();
    }

    public function signin()
    {
        return view('login');
    }

    public function signinCallback(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('user/index');
        }

        return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }

    // public function signinCallback(Request $request)
    // {
    //     $username = $request->input('username');
    //     $email = $username . '@nsru.ac.th';
    //     $this->myauth->doSigninPostback();

    //     if ($staff = $this->dc->find_staff($username)) {

    //         if ($user = User::where('email', $email)->first()) {
    //             Auth::login($user);
    //         } else {
    //             $user = new User();
    //             $user->email = $email;
    //             $user->name = $staff->full_name;
    //             $user->password = Hash::make(Str::random(30));
    //             $user->save();
    //             Auth::login($user);
    //         }
    //         return redirect('user/index');
    //     } elseif ($student = $this->dc->find_student($username)) {
    //         if ($user = User::where('email', $email)->first()) {
    //             Auth::login($user);
    //         } else {
    //             $user = new User();
    //             $user->email = $email;
    //             $user->name = $student->full_name;
    //             $user->ldap_username = $student->ldap_username;
    //             $user->password = Hash::make(Str::random(30));
    //             $user->save();
    //             Auth::login($user);
    //         }
    //         return redirect('user/index');
    //     } else {
    //     }
    // }

    public function signout()
    {
        $url = route('user.signoutCallback');
        $signoutUrl = $this->myauth->getSignoutURL($url);
        return redirect($signoutUrl);
    }

    public function signoutCallback()
    {
        Auth::logout();
        session()->flush();
        $this->myauth->doSignoutPostback();
        return redirect('/');
    }
}
