<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class UsersController extends Controller {
    /**
     * Where to redirect after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register-user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }


    public function index()
    {
        return view('users.register-user');
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
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(Request $request)
    {
        $cat = User::create([
            'id' => Uuid::uuid4()->toString(),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
        $cat->save();

        return view('users.register-user');
    }
}