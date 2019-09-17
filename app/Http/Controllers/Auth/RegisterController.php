<?php

namespace App\Http\Controllers\Auth;

use App\{Action, User};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use App\Mail\Auth\VerifyMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // original method
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);

        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verify_token' => Str::random(), // Str::random(40);
            'status' => User::STATUS_INACTIVE,
        ]);
        
        if ( $user ) {
            $user->attachRole(4); // user role

            // sending email notification with queue
            \Mail::to($user->email)
                ->bcc(config('mail.mail_info'))
                ->queue(new VerifyMail($user));
        }

        // create action record
        $action = Action::create([
            'user_id' => 1,
            'type' => 'user',
            'type_id' => 1,
            'action' => 'create',
            'description' => 'Регистрация пользователя ' . $user->name . '.',
            // 'old_value' => $product->id,
            // 'new_value' => $product->id,
        ]);

        return $user;
    }


    /**
     * Overriding the parent method to disable automatic login
     */
    public function register()
    {
        $this->validator(request()->all())->validate();
        event(new Registered($user = $this->create(request()->all())));
    
        // return redirect()->route('login')
        //     ->with('success', 'Check your email and click on the link to verify.');

        session()->flash('message', 'Check your email and click on the link to verify.');
        return redirect()->route('login');
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be identified.');
        }

        $user->status = User::STATUS_ACTIVE;
        $user->verify_token = null;
        $user->email_verified_at = date('Y-m-d H:i:s');

        $user->save();

        // return redirect()->route('login')
        //     ->with('success', 'Your e-mail is verified. You can now login.');


        // create action record
        $action = Action::create([
            'user_id' => $user->id,
            'type' => 'user',
            'type_id' => $user->id,
            'action' => 'verify',
            'description' => 'Верификация пользователя ' . $user->name . '.',
            // 'old_value' => $product->id,
            // 'new_value' => $product->id,
        ]);

        session()->flash('message', 'Your e-mail is verified. You can now login.');

        return redirect()->route('login');
    }
}
