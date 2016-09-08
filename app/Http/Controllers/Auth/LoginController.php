<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use App\Models\Social;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $userSocial = Socialite::driver('facebook')->user();
        $user = User::where('email', $userSocial->email)->first();

        if ($userSocial) {
            Auth::login($user);

            return redirect()->to($this->redirectTo);
        }
        $temp = new Social();
        $user = User::create([
            'email' =>  $userSocial->email,
            'name' => $userSocial->name
        ]);
        $temp->user_id = $user->id;
        $temp->provider_user_id = $user->id;
        $temp->provider = 'facebook';
        $temp->save();
        Auth::login($user);

        return redirect()->to($this->redirectTo);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'username' => 'required|min:8|unique:users',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $typeLogin  = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credential = [
            $typeLogin => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credential)) {
            return redirect()->intended($this->redirectTo);
        }

        return redirect()->back()->withErrors([trans('auth.invalid_info')])->withInput($request->all());
    }

    public function register(Request $request) {
        $validate = $this->validator($request->all());

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput($request->all());
        }

        $user = $this->create($request->all());
        Auth::login($user);

        return redirect()->to($this->redirectTo);
    }
}
