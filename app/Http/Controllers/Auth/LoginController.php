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

    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver)
    {
        switch ($driver) {
            case 'twitter':
                $userSocial = Socialite::driver('twitter')->user();
                $user = User::where('email', $userSocial->email)->orWhere('email', $userSocial->nickname)->first();

                if ($user) {
                    Auth::login($user);

                    return redirect()->to($this->redirectTo);
                }
                $temp = new Social();
                $user = User::create([
                    'email' =>  $userSocial->email ? $userSocial->email : $userSocial->nickname,
                    'name' => $userSocial->name,
                ]);

                $temp->user_id = $user->id;
                $temp->provider_user_id = $userSocial->id;
                $temp->provider = 'twitter';
                $temp->save();
                Auth::login($user);

                return redirect()->to($this->redirectTo);

                break;

            default:
                $user = $this->handleProvider($driver);
                Auth::login($user);

                return redirect()->to($this->redirectTo);

                break;
        }
    }

    public function handleProvider($driver) {
        $userSocial = Socialite::driver($driver)->user();
        $user = User::where('email', $userSocial->email)->orWhere('email')->first();

        if ($user) {
            return $user;
        }
        $temp = new Social();
        $user = User::create([
            'email' =>  $userSocial->email,
            'name' => $userSocial->name,
        ]);

        $temp->user_id = $user->id;
        $temp->provider_user_id = $userSocial->id;
        $temp->provider = $driver;
        $temp->save();

        return $user;
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
