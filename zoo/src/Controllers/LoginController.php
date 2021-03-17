<?php

namespace Zoo\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Redirect;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $token = Str::random('40');
        $app_id = base64_encode(Config::get('app.zoo_app_id'));
        $app_secret = base64_decode(Config::get('app.zoo_app_secret'));
        $url_redirect = urlencode(Config::get('app.zoo_redirect_url'));
        $url = 'http://localhost:8000/login?app_id=' . $app_id . '&app_secret=' . $app_secret . '&url_redirect=' . $url_redirect . '&token=' . $token;

        $session = new Session();
        $session->set('zoo_token', $token);
        return  redirect()->to($url)->send();
    }

    public function store(Request $request)
    {
        $session = new Session();
        if (($request->token) == $session->get('zoo_token')) {
            if (!User::where('email', base64_decode($request->email))->first()) {
                $user = new User();
                $user->name = base64_decode($request->name);
                $user->email = base64_decode($request->email);
                $user->password = bcrypt(123456);
                $user->save();
            }
            $user = User::where('email', base64_decode($request->email))->first();
            if ($user) {
                Auth::loginUsingId($user->id);
                return redirect()->route('home');
            }
        }
    }
}
