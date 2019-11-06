<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
            'cpf' => 'required|cpf|unique:individuals',
            'birthdate' => 'required|date_format:d-m-Y|before:18 years ago',
            'name' => 'required|string|max:200',
            'nickname' => 'nullable|string|max:200',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Entities\User
     */
    protected function create(array $data)
    {

        DB::transaction(function () use ($data) {
            $user  = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $person = $user->person()->create([
                'name' => $data['name'],
                'nickname' => $data['nickname']
            ]);

            $individual = $person->individual()->create([
                'cpf' => $data['cpf'],
                'birthdate' => $data['birthdate']
            ]);

            return $user;
        });

    }
}

